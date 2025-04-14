<body class="horizontal-layout horizontal-menu 2-columns   menu-expanded" data-open="hover" data-menu="horizontal-menu"
    data-col="2-columns">
    <!-- fixed-top-->
    <nav
        class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow navbar-static-top navbar-light navbar-brand-center">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-md-none mr-auto"><a
                            class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                class="ft-menu font-large-1"></i></a></li>
                    <li class="nav-item">
                        <a class="navbar-brand" target="_blank" href="/">
                            <img class="brand-logo" alt="modern admin logo"
                                src="{{ asset('uploads/'.get_general_value('website_icon')) }}" width="40" height="40">
                            <h3 class="brand-text">{{ get_general_value('website_name') }}</h3>
                        </a>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i
                                class="la la-ellipsis-v"></i></a>
                    </li>
                </ul>
            </div>
            <div class="navbar-container content">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">
                      
                        <li class="nav-item nav-search">
                            <input type="text" id="clientSearch" class="form-control" placeholder="ابحث برقم العضوية...">
                            <div id="clientResults" class="dropdown-menu show" style="display: none; position: absolute; z-index: 1000; width: 250px;"></div>
                        </li>
                     
                    </ul>
                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-user nav-item">
                            <a class="dropdown-toggle nav-link dropdown-user-link" href="#"
                                data-toggle="dropdown">
                                <span class="mr-1">{{ __('مرحبا') }},
                                    <span class="user-name text-bold-700">{{ auth()->user()->firstName }}</span>
                                </span>
                                <span class="avatar avatar-online profile-image">
                                    <img src="{{ asset('uploads/'.auth()->user()->image) }}"
                                        alt="avatar" ><i></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="{{route('edit_profile')}}" ><i
                                        class="ft-user"></i> {{ __('تعديل الملف الشخصي') }}</a>
                                <div class="dropdown-divider"></div><a class="dropdown-item" href="{{ route('logout') }}"><i
                                        class="ft-power"></i> {{ __('تسجيل خروج') }}</a>
                            </div>
                        </li>
                        
                        <li class="dropdown dropdown-notification nav-item">
                            <a class="nav-link nav-link-label" href="#" data-toggle="dropdown">
                                <i class="ficon ft-bell"></i>
                                <span class="badge badge-pill badge-default badge-danger badge-default badge-up badge-glow"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                             
                                <li class="scrollable-container media-list w-100">
                                    <!-- سيتم إضافة الإشعارات هنا عبر JavaScript -->
                                </li>
                               
                            </ul>
                        </li>
                        
                      
                    </ul>
                </div>
            </div>
        </div>
    </nav>
