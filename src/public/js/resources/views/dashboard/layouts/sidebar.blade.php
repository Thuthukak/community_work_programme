<div class="sidebar" id="sidebar">
    <div class="scrollbar-inner sidebar-wrapper position-relative">
        <ul class="nav">
            <li class="nav-item" id="dashboard">
                <a href="{{ route('dashboard') }}">
                    <i class="la la-dashboard"></i>
                    <p>{{ __('theme.dashboard') }}</p>
                </a>
            </li>
            @if(!Auth::user()->is_admin &&  Auth::user()->user_type == 0)
            <li class="nav-item" id="knowledge">
                <a href="{{ route('submit-new-ticket.create') }}" target="_blank">
                    <i class="fa fa-ticket"></i>
                    <p>{{ __('theme.add_new_ticket') }}</p>
                </a>
            </li>
            <li class="nav-item" id="dashboard">
                <a href="{{ route('KnowledgeBaseIndex') }}" target="_blank">
                    <i class="la la-book"></i>
                    <p>{{ __('theme.knowledge') }}</p>
                </a>
            </li>
            @endif
            @if($permission->manageTicket() == 1)
            <li id="tickets" class="nav-item">
                <div id="ticketsID">
                    <a href="#submenuTickets" data-toggle="collapse" aria-expanded="false" class="list-group-item border-0">
                        <div class="d-flex w-100 justify-content-start align-items-center">
                            <span class="fa fa-ticket fa-fw mr-3"></span> 
                            <span class="menu-collapsed">{{ __('theme.tickets') }}</span>
                            <span class="submenu-icon ml-auto"></span>
                        </div>
                    </a>
                </div>
                
                <!-- Submenu content -->
                <ul id='submenuTickets' class="collapse sidebar-submenu">
                    <li class="alltickets {{ (request()->segment(1) == 'tickets') ? 'active': '' }}">
                        <a href="{{ route('tickets.index') }}" class="border-0">
                        <span class="menu-collapsed">{{ __('theme.all_tickets') }}</span>
                        </a>
                    </li>
                    <li class="opened-tickets {{ (request()->segment(1) == 'opened-tickets') ? 'active': '' }}">
                        <a href="{{ route('opened-tickets.openedTickets') }}" class="border-0">
                            <span class="menu-collapsed">{{ __('theme.open_tickets') }}</span>
                        </a>
                        
                    </li>
                    <li class="closed-tickets {{ (request()->segment(1) == 'closed-tickets') ? 'active': '' }}">
                       <a href="{{ route('closed-tickets.ClosedTickets') }}" class="border-0">
                            <span class="menu-collapsed">{{ __('theme.closed_tickets') }}</span>
                        </a> 
                    </li>
                    
                    <li class="closed-tickets {{ (request()->segment(1) == 'custom-fields') ? 'active': '' }}">
                       <a href="{{ route('CustomFields') }}" class="border-0">
                            <span class="menu-collapsed">{{ __('theme.custom_fields') }}</span>
                        </a> 
                    </li>
                    
                </ul>
            </li>
            @endif
            @if($permission->manageDepartment() == 1 )
            <li class="nav-item" id="department">
                <a href="{{ route('departments.index') }}">
                    <i class="la la-th-list"></i>
                    <p>{{ __('theme.departments') }}</p>
                </a>
            </li>
            @endif
            
            @if($permission->manageKB() == 1 )
            <li class="nav-item" id="kb">
                <a href="{{ route('knowledge-base.index') }}">
                    <i class="la la-leanpub"></i>
                    <p>{{ __('theme.knowledge_base') }}</p>
                </a>
            </li>
            @endif
            @if($permission->manageStaff() == 1 )
            <li class="nav-item" id="staff">
                <a href="{{ route('staffs.staffList') }}">
                    <i class="la la-user-secret"></i>
                    <p>{{ __('theme.staffs') }}</p>
                </a>
            </li>
            @endif
            @if($permission->manageUser() == 1 )
            <li class="nav-item" id="users">
                <a href="{{ route('users.userList') }}">
                    <i class="la la-user"></i>
                    <p>{{ __('theme.users') }}</p>
                </a>
            </li>
            @endif
            @if($permission->manageRole() == 1 )
            <li class="nav-item" id="roles">
                <a href="{{ route('roles.index') }}">
                    <i class="la la-shield"></i>
                    <p>{{ __('theme.manage_roles') }}</p>
                </a>
            </li>
            @endif

            @if($permission->manageTranslation() == 1 )
                <li class="nav-item" id="langTranslations">
                    <a href="{{ route('languages.index') }}">
                        <i class="la la-language"></i>
                        <p>{{ __('translation.translations') }}</p>
                    </a>
                </li>
            @endif

            @if($permission->manageAppSetting() == 1 || $permission->manageEmailSetting() == 1 || $permission->manageEmailTemplate() == 1)
            <li class="nav-item" id="settings">
                <div id="appSettings">
                    <a href="#submenuSetting" data-toggle="collapse" aria-expanded="false" class="list-group-item border-0">
                    <i class="la la-gears"></i> <span>{{ __('theme.settings') }}</span>
                        <span class="submenu-icon ml-auto"></span>
                    </a>
                </div>
                
                <ul id='submenuSetting' class="collapse sidebar-submenu">
                    @if($permission->manageAppSetting() == 1)
                        <li><a href="{{ route('app-settings.settingIndex') }}">{{ __('theme.app_setting') }}</a></li>
                    @endif
                    @if($permission->manageEmailSetting() == 1)
                        <li><a href="{{ route('emailSetting') }}">{{ __('theme.email_setting') }}</a></li>
                    @endif
                    @if($permission->manageEmailTemplate() == 1)
                        <li><a href="{{ route('email-template.index') }}">{{ __('theme.email_template') }}</a></li>
                    @endif
                </ul>
            </li>
            @endif

            @if($permission->manageLogoIcon() == 1 || $permission->manageSocialLink() == 1 || $permission->manageHowWork() == 1 || $permission->manageCounter() == 1 || $permission->manageBanerText() == 1 || $permission->manageTestimonial() == 1 || $permission->manageService() == 1 || $permission->manageAboutUs() == 1 || $permission->manageFooter() == 1)
            <li class="nav-item" id="frontend">
                <div id="webSetting">
                    <a href="#submenuFrontend" data-toggle="collapse" aria-expanded="false" class="list-group-item border-0">
                    <i class="fa fa-fw fa-list"></i> <span>{{ __('theme.frontend_settings') }}</span>
                        <span class="submenu-icon ml-auto"></span>
                    </a>
                </div>
                
                <ul id='submenuFrontend' class="collapse sidebar-submenu">
                    @if($permission->manageLogoIcon() == 1)
                        <li><a href="{{ route('logoIcon.Setting') }}">{{ __('theme.logo_icon') }}</a></li>
                    @endif
                    @if($permission->manageSocialLink() == 1)
                        <li><a href="{{ route('social.Setting') }}">{{ __('theme.social_link') }}</a></li>
                    @endif
                    @if($permission->manageBanerText() == 1)
                        <li><a href="{{ route('headerTextSetting') }}">{{ __('theme.banner_text') }}</a></li>
                    @endif
                    @if($permission->manageHowWork() == 1)
                        <li><a href="{{ route('how-we-work.index') }}">{{ __('theme.how_we_work') }}</a></li>
                    @endif
                    @if($permission->manageService() == 1)
                        <li><a href="{{ route('service.index') }}">{{ __('theme.service_setting') }}</a></li>
                    @endif
                    @if($permission->manageCounter() == 1)
                        <li><a href="{{ route('counter.Setting') }}">{{ __('theme.counter_setting') }}</a></li>
                    @endif
                    @if($permission->manageTestimonial() == 1)
                        <li><a href="{{ route('testimonial.index') }}">{{ __('theme.testimonial') }}</a></li>
                    @endif
                    @if($permission->manageAboutUs() == 1)
                        <li><a href="{{ route('aboutus.Setting') }}">{{ __('theme.about_us') }}</a></li>
                    @endif
                    @if($permission->manageFooter() == 1)
                        <li><a href="{{ route('footer.Setting') }}">{{ __('theme.footer') }}</a></li>
                    @endif
                </ul>
            </li>
            @endif
            @if(Auth::user()->is_admin)
            <li class="nav-item" id="inbox">
                <a href="{{ route('contactMessage') }}">
                    <i class="la la-envelope"></i>
                    <p>{{ __('theme.inbox') }}</p>
                </a>
            </li>
            @endif
        </ul>
        <ul class="nav position-absolute">
            <li class="nav-item">
                <p class="nav pl-4 text-muted">{{ __('theme.version') }}: {{ config('devstar.app_version') }}</p>
            </li>
        </ul>
    </div>
</div>