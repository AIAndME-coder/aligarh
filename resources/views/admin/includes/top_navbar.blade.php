<style>
    /* Badge on bell icon */
    .badge-unread {
        position: absolute;
        top: -4px;
        right: -4px;
        background-color: #e0245e;
        color: white;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 3px 7px;
        border-radius: 50%;
        line-height: 1;
        user-select: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        transition: transform 0.2s ease;
    }

    .badge-unread:hover {
        transform: scale(1.1);
    }

    /* Dropdown container */
    .notification-dropdown {
        min-width: 340px;
        max-height: 320px;
        overflow-y: auto;
        border-radius: 12px;
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        border: 1px solid rgba(0, 0, 0, 0.05);
        padding: 0;
        animation: slideDown 0.3s ease-out;
    }

    /* Animation for dropdown */
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Each notification card */
    .notification-mini-card {
        cursor: pointer;
        padding: 12px 16px;
        border-radius: 8px;
        transition: all 0.2s ease;
        border-left: 4px solid transparent;
        margin: 8px;
        background: #f8fafc;
    }

    .notification-mini-card:hover {
        background-color: #e6f0fa;
        /* border-left-color: #1ab394; */
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Notification icon style */
    .notification-mini-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #1ab394 0%, #17a084 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Notification content container */
    .notification-mini-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    /* Message text style */
    .notification-mini-message {
        font-size: 0.95rem;
        font-weight: 600;
        color: #1f2a44;
        line-height: 1.5;
        max-width: 240px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Meta info (user + time) */
    .notification-mini-meta {
        font-size: 0.8rem;
        color: #4b5563;
        line-height: 1.4;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* New badge */
    .notification-mini-status {
        background-color: #e0245e;
        color: white;
        font-weight: 600;
        font-size: 0.7rem;
        padding: 2px 8px;
        border-radius: 12px;
        user-select: none;
        align-self: flex-start;
    }

    /* Footer */
    .notification-mini-footer {
        padding: 12px;
        background: #f8fafc;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    .notification-mini-footer a {
        color: #1ab394;
        font-size: 0.95rem;
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .notification-mini-footer a:hover {
        color: #158876;
        text-decoration: none;
    }

    /* Scrollbar style for webkit browsers */
    .notification-dropdown::-webkit-scrollbar {
        width: 8px;
    }

    .notification-dropdown::-webkit-scrollbar-thumb {
        background-color: rgba(26, 179, 148, 0.5);
        border-radius: 4px;
    }

    .notification-dropdown::-webkit-scrollbar-track {
        background: #f1f5f9;
    }

    /* Ensure dropdown stays within viewport */
    .notification-dropdown {
        max-width: 90vw;
    }
</style>
<div class="row border-bottom">
    <nav class="navbar navbar-static-top ng-scope" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " id="nav_collapse" href="#"><i
                    class="fa fa-bars"></i> </a>
            <!--     <div role="search" style="padding: 15px 0px 0px 0px; float: left">
        <h3>Current Session: 2017-2018</h3>
    </div> -->
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <span class="m-r-sm text-muted welcome-message">Welcome to Aligarh Management System.</span>
            </li>
            {{-- <li class="dropdown" id="notification-app">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                    <i class="fa fa-bell"></i>
                    <span class="label label-primary" v-if="unreadCount > 0">@{{ unreadCount }}</span>
                </a>

                <div class="notification-dropdown dropdown-menu">
                    <div v-for="notification in notifications.slice(0, 5)" :key="notification.id"
                        class="notification-mini-card">
                        <div class="notification-mini-content">
                            <div class="notification-mini-message">
                                @{{ truncate(notification.notification, 40) }}
                            </div>
                            <div class="notification-mini-meta">
                                @{{ notification.user ? notification.user.name : 'System' }} • @{{ formatTime(notification.created_at) }}
                                <span v-if="!notification.is_read" class="notification-mini-status">New</span>
                            </div>
                        </div>
                    </div>

                    <div class="notification-mini-footer">
                        <a href="/notifications/logs">See all notifications</a>
                    </div>
                </div>
            </li> --}}

            <li>
                <a href="{{ URL('logout') }}">
                    <i class="fa fa-sign-out"></i> Log Out
                </a>
            </li>

        </ul>

    </nav>
    <!-- <script type="text/javascript">
        /*  $(document).ready(function(){

                $("#nav_collapse").click(function(){

                    $.post('{{ URL('user-settings/skincfg') }}', { _token: "{{ csrf_token() }}", nav_collapse: "mini-navbar" })
                    .done(function(data) {
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                showMethod: 'slideDown',
                                timeOut: 8000
                            };
                            toastr.success(data.toastrmsg.msg, data.toastrmsg.title);
                      }
                    )
                    .fail(function () {
                        alert("Fail");
                    });

                });

              });*/
    </script> -->
</div>
<script src="{{ URL::to('src/js/plugins/axios-1.11.0/axios.min.js') }}"></script>
<script src="{{ URL::to('src/js/plugins/moment/moment.min.js') }}"></script>
{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        new Vue({
            el: '#notification-app',
            data: {
                notifications: [],
                per_page: 5,
                isLoading: false
            },
            computed: {
                unreadCount() {
                    return this.notifications.filter(n => n && !n.is_read)
                    .length; // Ensuring `n` is not null or undefined
                }
            },
            methods: {
                truncate(text, length) {
                    if (!text) return ''; // Handle null or undefined text
                    return text.length <= length ? text : text.substring(0, length) + '...';
                },
                formatTime(date) {
                    if (!date || !moment(date).isValid())
                return 'Invalid date'; // Handle null, undefined, or invalid dates
                    return moment(date).fromNow();
                },
                loadNotifications() {
                    this.isLoading = true;
                    axios.get('/notifications/logs', {
                            params: {
                                per_page: this.per_page
                            }
                        })
                        .then((response) => {
                            // Ensure notifications exists and is an array
                            this.notifications = Array.isArray(response.data.notifications) ?
                                response.data.notifications : [];
                        })
                        .catch(() => {
                            console.error('Failed to load navbar notifications');
                        })
                        .finally(() => {
                            this.isLoading = false;
                        });
                }
            },
            mounted() {
                this.loadNotifications();
            }
        });
    });
</script> --}}
