@php use Illuminate\Support\Str; @endphp

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
                    <span class="glyphicon glyphicon-save"></span> @lang('modules.buttons_update') {{ __('modules.module_permissions') }}
                </button>
            </div>
        </div>

    </div>
</form>
