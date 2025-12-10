@php use Illuminate\Support\Str; @endphp

<style>
    .permission-group {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 22px;
        margin-bottom: 35px;
    }

    .permission-group h4 {
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #333;
        display: flex;
        align-items: center;
        cursor: pointer;
        user-select: none;
    }

    .permission-group h4:hover {
        color: #10b981;
    }

    .permission-group h4 input[type="checkbox"]:checked ~ * {
        color: #10b981;
    }

    .permission-group .select-all {
        margin-right: 8px;
        cursor: pointer;
    }

    .permission-card {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 14px 16px;
        transition: .2s ease;
        cursor: pointer;
        margin-bottom: 10px;
    }

    .permission-card:hover {
        background: #f3f4f6;
        border-color: #d1d5db;
    }

    .permission-card.checked {
        background: #ecfdf5 !important;
        border-color: #34d399 !important;
    }

    .permission-card-header {
        font-size: 14px;
        font-weight: 600;
        color: #222;
        display: flex;
        align-items: center;
    }

    .permission-card-header input {
        margin-right: 10px;
    }

    .permission-card-header input:checked ~ span {
        color: #10b981;
        font-weight: 700;
    }

    .info-icon {
        margin-left: 8px;
        width: 18px;
        height: 18px;
        background: #3b82f6;
        color: #fff;
        border-radius: 50%;
        font-size: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: help;
    }

    .dependency-list {
        padding: 10px;
        background: #eef2ff;
        border-radius: 6px;
        border-left: 3px solid #6366f1;
        margin-top: 10px;
        display: none;
    }

    .permission-card.expanded .dependency-list {
        display: block !important;
    }

    .dependency-item {
        display: inline-block;
        padding: 4px 10px;
        background: #e5e7eb;
        border-radius: 4px;
        font-size: 12px;
        margin: 4px 6px 4px 0;
        color: #374151;
    }

    .dependency-item.auto-granted {
        background: #d1fae5;
        border: 1px solid #10b981;
        color: #059669;
    }

    .auto-grant-notice {
        background: #ecfdf5;
        border-left: 4px solid #10b981;
        border-radius: 6px;
        padding: 14px 18px;
        font-size: 14px;
        color: #065f46;
        margin-bottom: 20px;
        display: none;
    }

    .auto-grant-notice.show {
        display: block;
    }

    .tenant-permission-notice {
        background: #fef3c7;
        border-left: 4px solid #f59e0b;
        border-radius: 6px;
        padding: 14px 18px;
        font-size: 14px;
        color: #92400e;
        margin-bottom: 20px;
    }
</style>

<form id="module_permissions_form" method="post" action="{{ URL('system-setting/module-permissions') }}" class="form-horizontal">
    {{ csrf_field() }}

    <div class="ibox-content">
        <!-- Tenant Permission Notice -->
        <div class="tenant-permission-notice">
            <strong>🔒 Tenant-Level Permission Control</strong><br>
            This page allows you to control which permissions are available for this tenant's users. 
            Only enabled permissions will be available when creating or editing roles. 
            Developer role bypasses these restrictions.
        </div>

        <!-- Auto-Grant Notice -->
        <div class="auto-grant-notice" id="autoGrantNotice">
            <strong>📌 Note:</strong> When you select permissions with dependencies, 
            the required permissions will be automatically enabled. 
            For example, enabling "Create" will automatically enable "View" access.
        </div>

        <!-- Permission Groups -->
        @foreach($permissions as $groupName => $groupPermissions)
            <div class="permission-group">

                <label class="permission-group-label" style="margin: 0; cursor: pointer;">
                    <input type="checkbox"
                        class="select-all"
                        data-group="{{ Str::slug($groupName) }}">
                    <h4 style="margin: 0; display: inline-block; margin-left: 8px;">{{ $groupName }}</h4>
                </label>

                <div class="row" style="margin-top: 8px">
                    @foreach($groupPermissions as $permission => $details)
                        @php
                            $isObject = is_array($details);
                            $label = $isObject ? $details['label'] : $details;
                            $dependencies = $isObject ? ($details['dependencies'] ?? []) : [];
                            $hasDependencies = !empty($dependencies);
                            $isAllowed = in_array($permission, $allowedPermissions);
                        @endphp

                        <div class="col-md-4">
                            <div class="permission-card {{ $isAllowed ? 'checked' : '' }}">

                                <label class="permission-card-header" style="margin: 0; cursor: pointer;">

                                    <input type="checkbox"
                                        name="permissions[]"
                                        value="{{ $permission }}"
                                        class="{{ Str::slug($groupName) }} {{ $hasDependencies ? 'permission-with-deps' : '' }}"
                                        data-permission="{{ $permission }}"
                                        data-dependencies="{{ implode(',', $dependencies) }}"
                                        {{ $isAllowed ? 'checked' : '' }}>

                                    <span style="user-select: none;">{{ $label }}</span>

                                    @if($hasDependencies)
                                        <span class="info-icon" title="Auto-enables required permissions">i</span>
                                    @endif
                                </label>

                                @if($hasDependencies)
                                <div class="dependency-list">
                                    <strong>Requires:</strong><br>
                                    @foreach($dependencies as $dep)
                                        <span class="dependency-item" data-dependency="{{ $dep }}">✓ {{ $permissionLabels[$dep] ?? $dep }}</span>
                                    @endforeach
                                </div>
                                @endif

                            </div>
                        </div>

                    @endforeach
                </div>

            </div>
        @endforeach

        <div class="form-group">
            <div class="col-md-12">
                <button class="btn btn-primary" type="submit">
                    <span class="glyphicon glyphicon-save"></span> {{ __('common.save') }} {{ __('modules.module_permissions') }}
                </button>
            </div>
        </div>

    </div>
</form>

<script type="text/javascript">
$(document).ready(function() {

    // Build dependency map from data attributes
    var dependencyMap = {};
    $('input[name="permissions[]"][data-dependencies]').each(function() {
        var perm = $(this).data('permission');
        var deps = $(this).data('dependencies').split(',');
        dependencyMap[perm] = deps.map(function(d) { return $.trim(d); });
    });

    // Initialize select-all checkboxes based on existing permissions
    $('.select-all').each(function() {
        var group = $(this).data('group');
        var totalInGroup = $('.' + group).length;
        var checkedInGroup = $('.' + group + ':checked').length;
        
        if (checkedInGroup === totalInGroup && totalInGroup > 0) {
            $(this).prop('checked', true);
        }
    });

    // Handle Select All functionality
    $('.select-all').change(function() {
        var group = $(this).data('group');
        var isChecked = $(this).is(':checked');
        
        $('.' + group).prop('checked', isChecked);
        updateDependencyIndicators();
    });

    // Make permission group label clickable for select-all
    $('.permission-group-label').on('click', function(e) {
        if ($(e.target).is('input[type="checkbox"]')) {
            return;
        }
        
        var $checkbox = $(this).find('.select-all');
        if ($checkbox.length) {
            $checkbox.prop('checked', !$checkbox.is(':checked')).trigger('change');
            e.preventDefault();
        }
    });

    // Make entire permission card clickable
    $('.permission-card').on('click', function(e) {
        // Don't double-trigger if clicking the checkbox or info icon
        if ($(e.target).is('input[type="checkbox"]') || $(e.target).closest('.info-icon').length) {
            return;
        }
        
        var $checkbox = $(this).find('input[type="checkbox"]');
        if ($checkbox.length) {
            $checkbox.prop('checked', !$checkbox.is(':checked')).trigger('change');
            e.preventDefault();
        }
    });
    
    // Handle individual checkbox changes with auto-check for dependencies
    $('input[name="permissions[]"]').change(function() {
        var permission = $(this).data('permission');
        var isChecked = $(this).is(':checked');
        var dependencyMap = buildDependencyMap();
        
        // Auto-check dependencies if this permission is checked
        if (isChecked && dependencyMap[permission]) {
            dependencyMap[permission].forEach(function(dep) {
                var $depCheckbox = $('input[data-permission="' + dep + '"]');
                if ($depCheckbox.length && !$depCheckbox.is(':checked')) {
                    $depCheckbox.prop('checked', true);
                    $depCheckbox.closest('.permission-card')
                        .addClass('checked').addClass('expanded');
                }
            });
        }
        
        // Update group select-all checkbox
        var $thisCheckbox = $(this);
        var classes = $thisCheckbox.attr('class').split(' ');
        var groupClass = classes.find(function(c) { 
            return c !== 'permission-with-deps' && c.indexOf('-') > -1;
        });
        
        if (groupClass) {
            var totalInGroup = $('.' + groupClass).length;
            var checkedInGroup = $('.' + groupClass + ':checked').length;
            
            if (checkedInGroup === totalInGroup) {
                $('.select-all[data-group="' + groupClass + '"]').prop('checked', true);
            } else {
                $('.select-all[data-group="' + groupClass + '"]').prop('checked', false);
            }
        }
        
        updateDependencyIndicators();
    });

    // Build dependency map from data attributes
    function buildDependencyMap() {
        var dependencyMap = {};
        $('input[data-dependencies]').each(function() {
            var permission = $(this).data('permission');
            var deps = $(this).data('dependencies');
            if (deps && typeof deps === 'string') {
                dependencyMap[permission] = deps.split(',').map(function(d) { return d.trim(); });
            } else if (deps && Array.isArray(deps)) {
                dependencyMap[permission] = deps;
            }
        });
        return dependencyMap;
    }

    // Function to update dependency indicators and visual feedback
    function updateDependencyIndicators() {
        var dependencyMap = buildDependencyMap();
        var checkedPermissions = [];
        var hasDependencies = false;
        var autoGrantedDependencies = {};

        // Collect all checked permissions
        $('input[name="permissions[]"]:checked').each(function() {
            var permission = $(this).data('permission');
            checkedPermissions.push(permission);
            
            // Track auto-granted dependencies
            if (dependencyMap[permission]) {
                hasDependencies = true;
                dependencyMap[permission].forEach(function(dep) {
                    if (!autoGrantedDependencies[dep]) {
                        autoGrantedDependencies[dep] = [];
                    }
                    autoGrantedDependencies[dep].push(permission);
                });
            }
        });

        // Show/hide auto-grant notice
        if (hasDependencies) {
            $('#autoGrantNotice').addClass('show');
        } else {
            $('#autoGrantNotice').removeClass('show');
        }

        // Update visual indicators for each permission with dependencies
        $('input[data-dependencies]').each(function() {
            var $container = $(this).closest('.permission-card');
            var permission = $(this).data('permission');
            var isChecked = $(this).is(':checked');
            
            if (isChecked) {
                $container.addClass('checked');
                if (dependencyMap[permission]) {
                    $container.addClass('expanded');
                }
            } else {
                $container.removeClass('checked');
                // Only keep expanded if showing dependencies needed
                if (!dependencyMap[permission]) {
                    $container.removeClass('expanded');
                }
            }
        });

        // Highlight dependency items that are auto-granted
        $('.dependency-item').each(function() {
            var depName = $(this).data('dependency');
            if (depName && autoGrantedDependencies[depName]) {
                $(this).addClass('auto-granted');
            } else {
                $(this).removeClass('auto-granted');
            }
        });
    }

    // Initialize on page load
    updateDependencyIndicators();
});
</script>
