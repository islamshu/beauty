<div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-shadow"
    role="navigation" data-menu="menu-wrapper">
    <div class="navbar-container main-menu-content" data-menu="menu-container">
        <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="dropdown nav-item" data-menu="dropdown">
                <a class=" nav-link" href="{{ route('dashboard') }}"><i class="la la-home"></i>
                    <span>{{ __('الرئيسية') }}</span>
                </a>

            </li>

            @can('الإعدادات')
                <li class="dropdown nav-item" data-menu="dropdown">
                    <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                        <i class="la la-magic"></i><span>{{ __('الإعدادات') }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('setting') }}">{{ __('الإعدادات الاساسية للنظام') }}</a>
                        </li>
                        <li><a class="dropdown-item"
                                href="{{ route('social_media') }}">{{ __('الإعدادات بيانات السوشل ميديا ') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('sliders.index') }}">{{ __('السلاديرات') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('aboutus.index') }}">{{ __('من نحن') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('galleries.index') }}">{{ __('قائمة الصور') }}</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('partners.index') }}">{{ __('شركائنا') }}</a></li>
                    </ul>
                </li>
            @endcan
            @can('الادوار والاذونات')
                <li class="nav-item" data-menu="dropdown">
                    <a class="nav-link" href="{{ route('roles.index') }}">
                        <i class="la la-user-secret"></i><span>{{ __('الادوار والاذونات') }}</span>
                    </a>
                </li>
            @endcan
            @can('الموظفين')
                <li class="dropdown nav-item" data-menu="dropdown">
                    <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                        <i class="la la-users"></i><span>{{ __('الموظفين') }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('users.index') }}">{{ __('جميع الموظفين') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('users.create') }}">{{ __('اضف موظف جديد') }}</a></li>
                    </ul>
                </li>
            @endcan

            @can('الباقات')
                <li class="dropdown nav-item" data-menu="dropdown">
                    <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                        <i class="la la-server"></i><span>{{ __('الباقات') }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('packages.index') }}">{{ __('جميع الباقات') }}</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('packages.create') }}">{{ __('اضف باقة جديدة') }}</a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('التصنيفات والخدمات')
                <li class="dropdown nav-item" data-menu="dropdown">
                    <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                        <i class="la la-bars"></i><span>{{ __('التصنيفات والخدمات') }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('categories.index') }}">{{ __('التصنيفات') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('services.index') }}">{{ __('الخدمات') }}</a></li>
                    </ul>
                </li>
            @endcan

            @can('الدورات')
                <li class="nav-item" data-menu="dropdown">
                    <a class="nav-link" href="{{ route('courses.index') }}">
                        <i class="la la-book"></i><span>{{ __('الدورات') }}</span>
                    </a>
                </li>
            @endcan

            @can('العملاء')
                <li class="dropdown nav-item" data-menu="dropdown">
                    <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                        <i class="la la-user-plus"></i><span>{{ __('العملاء') }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('clients.index') }}">{{ __('جميع العملاء') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('clients.active') }}">{{ __('العملاء الفعالين') }}</a>
                        </li>
                        <li><a class="dropdown-item"
                                href="{{ route('clients.notactive') }}">{{ __('العملاء الغير فعالة') }}</a></li>
                    </ul>
                </li>
            @endcan

            @can('الحجوزات')
                <li class="dropdown nav-item" data-menu="dropdown">
                    <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                        <i class="la la-calendar"></i><span>{{ __('الحجوزات') }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('reservations.index') }}">{{ __('الحجوزات') }}</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('reservations.create') }}">{{ __('حجز جديد') }}</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('calender') }}">{{ __('التقويم') }}</a></li>
                    </ul>
                </li>
            @endcan

            @can('الطلبات')
                @php
                    $totalPendingOrders = App\Models\Order::where('status', 0)->count();
                    $totalPendingContacts = App\Models\Contact::where('show', 0)->count();
                    $totalcourst = App\Models\Enrollment::where('status', 0)->count();
                    $totalPendingRequests = $totalPendingOrders + $totalPendingContacts;
                @endphp
                <li class="dropdown nav-item" data-menu="dropdown">
                    <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                        <i class="la la-reorder"></i><span>{{ __('الطلبات') }}</span>
                        <span class="badge badge-danger badge-pill ml-1">{{ $totalPendingRequests }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('packge_order') }}">
                                {{ __('طلبات الباقات') }}
                                <span class="badge badge-danger badge-pill float-right">{{ $totalPendingOrders }}</span>
                            </a></li>
                        <li><a class="dropdown-item" href="{{ route('contact_order') }}">
                                {{ __('طلبات التواصل') }}
                                <span class="badge badge-danger badge-pill float-right">{{ $totalPendingContacts }}</span>
                            </a></li>
                        <li><a class="dropdown-item" href="{{ route('orders.index') }}">
                                {{ __('طلبات المتجر') }}
                                <span
                                    class="badge badge-danger badge-pill float-right">{{ App\Models\Order::count() }}</span>
                            </a></li>
                        <li><a class="dropdown-item" href="{{ route('courses_order') }}">
                                {{ __('طلبات الدورات') }}
                                <span
                                    class="badge badge-danger badge-pill float-right">{{ App\Models\Enrollment::count() }}</span>
                            </a></li>
                    </ul>
                </li>
            @endcan

            @can('التقارير')
                <li class="dropdown nav-item" data-menu="dropdown">
                    <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                        <i class="la la-book"></i><span>{{ __('التقارير') }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item"
                                href="{{ route('reports.subsciption') }}">{{ __('الاشتراكات') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('reports.payments') }}">{{ __('المدفوعات') }}</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('reports.visits') }}">{{ __('الزيارات') }}</a></li>
                    </ul>
                </li>
            @endcan



            {{--  <li class=" nav-item" ><a class=" nav-link"
                        href="{{route('edit_section')}}" ><i
                            class="la la-television"></i><span>{{ __('تعديل القسم اسفل الفيديو') }}</span></a>
                 
                </li>

                
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link"
                        href="#" data-toggle="dropdown"><i
                            class="la la-television"></i><span>{{ __('الشركاء') }}</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown " data-menu=""><a
                                class="dropdown-item " href="{{ route('partners.index') }}"
                                >{{ __('جميع الشركاء ') }}</a>
                        </li>
                        <li class="dropdown " data-menu=""><a
                                class="dropdown-item " href="{{ route('partners.create') }}"
                                >{{ __('اضف شريك جديد') }}</a>
                        </li>
                       
                       
                    </ul>
                </li>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link"
                        href="#" data-toggle="dropdown"><i
                            class="la la-television"></i><span>{{ __('التقيميات') }}</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown " data-menu=""><a
                                class="dropdown-item " href="{{ route('reviews.index') }}"
                                >{{ __('جميع التقيميات ') }}</a>
                        </li>
                        <li class="dropdown " data-menu=""><a
                                class="dropdown-item " href="{{ route('reviews.create') }}"
                                >{{ __('اضف تقيم جديد') }}</a>
                        </li>
                       
                       
                    </ul>
                </li>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link"
                        href="#" data-toggle="dropdown"><i
                            class="la la-television"></i><span>{{ __('الفيديوهات') }}</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown " data-menu=""><a
                                class="dropdown-item " href="{{ route('videos.index') }}"
                                >{{ __('جميع الفيديوهات ') }}</a>
                        </li>
                        <li class="dropdown " data-menu=""><a
                                class="dropdown-item " href="{{ route('videos.create') }}"
                                >{{ __('اضف فيديو جديد') }}</a>
                        </li>
                       
                       
                    </ul>
                </li>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link"
                        href="#" data-toggle="dropdown"><i
                            class="la la-television"></i><span>{{ __('الاسئلة الشائعة') }}</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown " data-menu=""><a
                                class="dropdown-item " href="{{ route('faqs.index') }}"
                                >{{ __('جميع الاسئلة ') }}</a>
                        </li>
                        <li class="dropdown " data-menu=""><a
                                class="dropdown-item " href="{{ route('faqs.create') }}"
                                >{{ __('اضف سؤال جديد') }}</a>
                        </li>
                       
                       
                    </ul>
                </li> --}}
            {{-- <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link"
                        href="#" data-toggle="dropdown"><i
                            class="la la-folder-open"></i><span>General</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-paint-brush"></i>Color Palette</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="color-palette-primary.html"
                                        data-toggle="dropdown">Primary palette</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="color-palette-danger.html"
                                        data-toggle="dropdown">Danger palette</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="color-palette-success.html"
                                        data-toggle="dropdown">Success palette</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="color-palette-warning.html"
                                        data-toggle="dropdown">Warning palette</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="color-palette-info.html"
                                        data-toggle="dropdown">Info palette</a>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li data-menu=""><a class="dropdown-item" href="color-palette-red.html"
                                        data-toggle="dropdown">Red palette</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="color-palette-pink.html"
                                        data-toggle="dropdown">Pink palette</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="color-palette-purple.html"
                                        data-toggle="dropdown">Purple palette</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="color-palette-blue.html"
                                        data-toggle="dropdown">Blue palette</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="color-palette-cyan.html"
                                        data-toggle="dropdown">Cyan palette</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="color-palette-teal.html"
                                        data-toggle="dropdown">Teal palette</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="color-palette-yellow.html"
                                        data-toggle="dropdown">Yellow palette</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="color-palette-amber.html"
                                        data-toggle="dropdown">Amber palette</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="color-palette-blue-grey.html"
                                        data-toggle="dropdown">Blue Grey palette</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-puzzle-piece"></i>Starter kit</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item"
                                        href="{{ asset('frontend/starter-kit/rtl/horizontal-menu-template-nav/horizontal-layout-1-column.html') }}"
                                        data-toggle="dropdown">1 column</a>
                                </li>
                                <li class="dropdown " data-menu=""><a
                                        class="dropdown-item dropdown-toggle" href="#"
                                        data-toggle="dropdown">Content Det. Sidebar</a>
                                    <ul class="dropdown-menu">
                                        <li data-menu=""><a class="dropdown-item"
                                                href="{{ asset('frontend/starter-kit/rtl/horizontal-menu-template-nav/layout-content-detached-left-sidebar.html') }}"
                                                data-toggle="dropdown">Detached left sidebar</a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item"
                                                href="{{ asset('frontend/starter-kit/rtl/horizontal-menu-template-nav/layout-content-detached-left-sticky-sidebar.html') }}"
                                                data-toggle="dropdown">Detached sticky left sidebar</a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item"
                                                href="{{ asset('frontend/starter-kit/rtl/horizontal-menu-template-nav/layout-content-detached-right-sidebar.html') }}"
                                                data-toggle="dropdown">Detached right sidebar</a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item"
                                                href="{{ asset('frontend/starter-kit/rtl/horizontal-menu-template-nav/layout-content-detached-right-sticky-sidebar.html') }}"
                                                data-toggle="dropdown">Detached sticky right sidebar</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li data-menu=""><a class="dropdown-item"
                                        href="{{ asset('frontend/starter-kit/rtl/horizontal-menu-template-nav/layout-fixed-navigation.html') }}"
                                        data-toggle="dropdown">Fixed navigation</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                        href="{{ asset('frontend/starter-kit/rtl/horizontal-menu-template-nav/layout-fixed.html') }}"
                                        data-toggle="dropdown">Fixed layout</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                        href="{{ asset('frontend/starter-kit/rtl/horizontal-menu-template-nav/layout-boxed.html') }}"
                                        data-toggle="dropdown">Boxed layout</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                        href="{{ asset('frontend/starter-kit/rtl/horizontal-menu-template-nav/layout-static.html') }}"
                                        data-toggle="dropdown">Static layout</a>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li data-menu=""><a class="dropdown-item"
                                        href="{{ asset('frontend/starter-kit/rtl/horizontal-menu-template-nav/layout-light.html') }}"
                                        data-toggle="dropdown">Light layout</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                        href="{{ asset('frontend/starter-kit/rtl/horizontal-menu-template-nav/layout-dark.html') }}"
                                        data-toggle="dropdown">Dark layout</a>
                                </li>
                            </ul>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item" href="changelog.html" data-toggle="dropdown"><i
                                    class="la la-copy"></i>Changelog</a>
                        </li>
                        <li class="disabled" data-menu=""><a class="dropdown-item" href="#"
                                data-toggle="dropdown"><i class="la la-eye-slash"></i>Disabled Menu</a>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-android"></i>Menu levels</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="#"
                                        data-toggle="dropdown">Second level</a>
                                </li>
                                <li class="dropdown " data-menu=""><a
                                        class="dropdown-item dropdown-toggle" href="#"
                                        data-toggle="dropdown">Second level child</a>
                                    <ul class="dropdown-menu">
                                        <li data-menu=""><a class="dropdown-item" href="#"
                                                data-toggle="dropdown">Third level</a>
                                        </li>
                                        <li class="dropdown " data-menu=""><a
                                                class="dropdown-item dropdown-toggle" href="#"
                                                data-toggle="dropdown">Third level child</a>
                                            <ul class="dropdown-menu">
                                                <li data-menu=""><a class="dropdown-item" href="#"
                                                        data-toggle="dropdown">Fourth level</a>
                                                </li>
                                                <li data-menu=""><a class="dropdown-item" href="#"
                                                        data-toggle="dropdown">Fourth level</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link"
                        href="#" data-toggle="dropdown"><i class="la la-file-text"></i><span>Pages</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-briefcase"></i>Project</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="project-summary.html"
                                        data-toggle="dropdown">Project Summary</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="project-tasks.html"
                                        data-toggle="dropdown">Project Task</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="project-bugs.html"
                                        data-toggle="dropdown">Project Bugs</a>
                                </li>
                            </ul>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item" href="scrumboard.html" data-toggle="dropdown"><i
                                    class="la la-check-square"></i>Scrumboard</a>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item" href="email-application.html" data-toggle="dropdown"><i
                                    class="la la-envelope"></i>Email Application</a>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item" href="chat-application.html" data-toggle="dropdown"><i
                                    class="la la-comments"></i>Chat Application</a>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-clipboard"></i>Invoice</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="invoice-summary.html"
                                        data-toggle="dropdown">Invoice Summary</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="invoice-template.html"
                                        data-toggle="dropdown">Invoice Template</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="invoice-list.html"
                                        data-toggle="dropdown">Invoice List</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-film"></i>Timelines</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="timeline-center.html"
                                        data-toggle="dropdown">Timelines Center</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="timeline-left.html"
                                        data-toggle="dropdown">Timelines Left</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="timeline-right.html"
                                        data-toggle="dropdown">Timelines Right</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="timeline-horizontal.html"
                                        data-toggle="dropdown">Timelines Horizontal</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-user"></i>Users</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="user-profile.html"
                                        data-toggle="dropdown">Users Profile</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="user-cards.html"
                                        data-toggle="dropdown">Users Cards</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="users-contacts.html"
                                        data-toggle="dropdown">Users List</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-image"></i>Gallery</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="gallery-grid.html"
                                        data-toggle="dropdown">Gallery Grid</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="gallery-grid-with-desc.html"
                                        data-toggle="dropdown">Gallery Grid with Desc</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="gallery-masonry.html"
                                        data-toggle="dropdown">Masonry Gallery</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="gallery-masonry-with-desc.html"
                                        data-toggle="dropdown">Masonry Gallery with Desc</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="gallery-hover-effects.html"
                                        data-toggle="dropdown">Hover Effects</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-search"></i>Search</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="search-page.html"
                                        data-toggle="dropdown">Search Page</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="search-website.html"
                                        data-toggle="dropdown">Search Website</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="search-images.html"
                                        data-toggle="dropdown">Search Images</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="search-videos.html"
                                        data-toggle="dropdown">Search Videos</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-unlock"></i>Authentication</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="login-simple.html"
                                        data-toggle="dropdown">Login Simple</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="login-with-bg.html"
                                        data-toggle="dropdown">Login with Bg</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="login-with-bg-image.html"
                                        data-toggle="dropdown">Login with Bg Image</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="login-with-navbar.html"
                                        data-toggle="dropdown">Login with Navbar</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="login-advanced.html"
                                        data-toggle="dropdown">Login Advanced</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="register-simple.html"
                                        data-toggle="dropdown">Register Simple</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="register-with-bg.html"
                                        data-toggle="dropdown">Register with Bg</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="register-with-bg-image.html"
                                        data-toggle="dropdown">Register with Bg Image</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="register-with-navbar.html"
                                        data-toggle="dropdown">Register with Navbar</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="register-advanced.html"
                                        data-toggle="dropdown">Register Advanced</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="unlock-user.html"
                                        data-toggle="dropdown">Unlock User</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="recover-password.html"
                                        data-toggle="dropdown">recover-password</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-warning"></i>Error</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="error-400.html"
                                        data-toggle="dropdown">Error 400</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="error-400-with-navbar.html"
                                        data-toggle="dropdown">Error 400 with Navbar</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="error-401.html"
                                        data-toggle="dropdown">Error 401</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="error-401-with-navbar.html"
                                        data-toggle="dropdown">Error 401 with Navbar</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="error-403.html"
                                        data-toggle="dropdown">Error 403</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="error-403-with-navbar.html"
                                        data-toggle="dropdown">Error 403 with Navbar</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="error-404.html"
                                        data-toggle="dropdown">Error 404</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="error-404-with-navbar.html"
                                        data-toggle="dropdown">Error 404 with Navbar</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="error-500.html"
                                        data-toggle="dropdown">Error 500</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="error-500-with-navbar.html"
                                        data-toggle="dropdown">Error 500 with Navbar</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-file-text"></i>Others</a>
                            <ul class="dropdown-menu">
                                <li class="dropdown " data-menu=""><a
                                        class="dropdown-item dropdown-toggle" href="#"
                                        data-toggle="dropdown">Coming Soon</a>
                                    <ul class="dropdown-menu">
                                        <li data-menu=""><a class="dropdown-item" href="coming-soon-flat.html"
                                                data-toggle="dropdown">Flat</a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item"
                                                href="coming-soon-bg-image.html" data-toggle="dropdown">Bg image</a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item"
                                                href="coming-soon-bg-video.html" data-toggle="dropdown">Bg video</a>
                                        </li>
                                    </ul>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="under-maintenance.html"
                                        data-toggle="dropdown">Maintenance</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link"
                        href="#" data-toggle="dropdown"><i class="la la-pencil"></i><span>UI</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-tablet"></i>Cards</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="card-bootstrap.html"
                                        data-toggle="dropdown">Bootstrap</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="card-headings.html"
                                        data-toggle="dropdown">Headings</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="card-options.html"
                                        data-toggle="dropdown">Options</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="card-actions.html"
                                        data-toggle="dropdown">Action</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="card-draggable.html"
                                        data-toggle="dropdown">Draggable</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-fire"></i>Advance Cards</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="card-statistics.html"
                                        data-toggle="dropdown">Statistics</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="card-weather.html"
                                        data-toggle="dropdown">Weather</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="card-charts.html"
                                        data-toggle="dropdown">Charts</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="card-interactive.html"
                                        data-toggle="dropdown">Interactive</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="card-maps.html"
                                        data-toggle="dropdown">Maps</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="card-social.html"
                                        data-toggle="dropdown">Social</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="card-ecommerce.html"
                                        data-toggle="dropdown">E-Commerce</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-compass"></i>Content</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="content-grid.html"
                                        data-toggle="dropdown">Grid</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="content-typography.html"
                                        data-toggle="dropdown">Typography</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="content-text-utilities.html"
                                        data-toggle="dropdown">Text utilities</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="content-syntax-highlighter.html"
                                        data-toggle="dropdown">Syntax highlighter</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="content-helper-classes.html"
                                        data-toggle="dropdown">Helper classes</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-server"></i>Components</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="component-alerts.html"
                                        data-toggle="dropdown">Alerts</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-callout.html"
                                        data-toggle="dropdown">Callout</a>
                                </li>
                                <li class="dropdown " data-menu=""><a
                                        class="dropdown-item dropdown-toggle" href="#"
                                        data-toggle="dropdown">Buttons</a>
                                    <ul class="dropdown-menu">
                                        <li data-menu=""><a class="dropdown-item"
                                                href="component-buttons-basic.html" data-toggle="dropdown">Basic
                                                Buttons</a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item"
                                                href="component-buttons-extended.html"
                                                data-toggle="dropdown">Extended Buttons</a>
                                        </li>
                                    </ul>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-carousel.html"
                                        data-toggle="dropdown">Carousel</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-collapse.html"
                                        data-toggle="dropdown">Collapse</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-dropdowns.html"
                                        data-toggle="dropdown">Dropdowns</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-list-group.html"
                                        data-toggle="dropdown">List Group</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-modals.html"
                                        data-toggle="dropdown">Modals</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-pagination.html"
                                        data-toggle="dropdown">Pagination</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-navs-component.html"
                                        data-toggle="dropdown">Navs Component</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-tabs-component.html"
                                        data-toggle="dropdown">Tabs Component</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-pills-component.html"
                                        data-toggle="dropdown">Pills Component</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-tooltips.html"
                                        data-toggle="dropdown">Tooltips</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-popovers.html"
                                        data-toggle="dropdown">Popovers</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-badges.html"
                                        data-toggle="dropdown">Badges</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-pill-badges.html"
                                        data-toggle="dropdown">Pill Badges</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-progress.html"
                                        data-toggle="dropdown">Progress</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-media-objects.html"
                                        data-toggle="dropdown">Media Objects</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-scrollable.html"
                                        data-toggle="dropdown">Scrollable</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="component-spinners.html"
                                        data-toggle="dropdown">Spinners</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-diamond"></i>Extra Components</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="ex-component-sweet-alerts.html"
                                        data-toggle="dropdown">Sweet Alerts</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="ex-component-tree-views.html"
                                        data-toggle="dropdown">Tree Views</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="ex-component-toastr.html"
                                        data-toggle="dropdown">Toastr</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="ex-component-ratings.html"
                                        data-toggle="dropdown">Ratings</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="ex-component-noui-slider.html"
                                        data-toggle="dropdown">NoUI Slider</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                        href="ex-component-date-time-dropper.html" data-toggle="dropdown">Date Time
                                        Dropper</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="ex-component-lists.html"
                                        data-toggle="dropdown">Lists</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="ex-component-toolbar.html"
                                        data-toggle="dropdown">Toolbar</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="ex-component-knob.html"
                                        data-toggle="dropdown">Knob</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="ex-component-long-press.html"
                                        data-toggle="dropdown">Long Press</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="ex-component-offline.html"
                                        data-toggle="dropdown">Offline</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="ex-component-zoom.html"
                                        data-toggle="dropdown">Zoom</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-eye"></i>Icons</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="icons-feather.html"
                                        data-toggle="dropdown">Feather</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="icons-line-awesome.html"
                                        data-toggle="dropdown">Line Awesome</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="icons-meteocons.html"
                                        data-toggle="dropdown">Meteocons</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="icons-simple-line-icons.html"
                                        data-toggle="dropdown">Simple Line Icons</a>
                                </li>
                            </ul>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item" href="animation.html" data-toggle="dropdown"><i
                                    class="la la-spinner spinner"></i>Animation</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link"
                        href="#" data-toggle="dropdown"><i class="la la-th-list"></i><span>Forms</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-terminal"></i>Form Elements</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="form-inputs.html"
                                        data-toggle="dropdown">Form Inputs</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-input-groups.html"
                                        data-toggle="dropdown">Input Groups</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-input-grid.html"
                                        data-toggle="dropdown">Input Grid</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-extended-inputs.html"
                                        data-toggle="dropdown">Extended Inputs</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-checkboxes-radios.html"
                                        data-toggle="dropdown">Checkboxes &amp; Radios</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-switch.html"
                                        data-toggle="dropdown">Switch</a>
                                </li>
                                <li class="dropdown " data-menu=""><a
                                        class="dropdown-item dropdown-toggle" href="#"
                                        data-toggle="dropdown">Select</a>
                                    <ul class="dropdown-menu">
                                        <li data-menu=""><a class="dropdown-item" href="form-select2.html"
                                                data-toggle="dropdown">Select2</a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="form-selectize.html"
                                                data-toggle="dropdown">Selectize</a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="form-selectivity.html"
                                                data-toggle="dropdown">Selectivity</a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="form-select-box-it.html"
                                                data-toggle="dropdown">Select Box It</a>
                                        </li>
                                    </ul>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-dual-listbox.html"
                                        data-toggle="dropdown">Dual Listbox</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-tags-input.html"
                                        data-toggle="dropdown">Tags Input</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-validation.html"
                                        data-toggle="dropdown">Validation</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-file-text"></i>Form Layouts</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="form-layout-basic.html"
                                        data-toggle="dropdown">Basic Forms</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-layout-horizontal.html"
                                        data-toggle="dropdown">Horizontal Forms</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-layout-hidden-labels.html"
                                        data-toggle="dropdown">Hidden Labels</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-layout-form-actions.html"
                                        data-toggle="dropdown">Form Actions</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-layout-row-separator.html"
                                        data-toggle="dropdown">Row Separator</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-layout-bordered.html"
                                        data-toggle="dropdown">Bordered</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-layout-striped-rows.html"
                                        data-toggle="dropdown">Striped Rows</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="form-layout-striped-labels.html"
                                        data-toggle="dropdown">Striped Labels</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-paste"></i>Form Wizard</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="form-wizard-circle-style.html"
                                        data-toggle="dropdown">Circle Style</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                        href="form-wizard-notification-style.html"
                                        data-toggle="dropdown">Notification Style</a>
                                </li>
                            </ul>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item" href="form-repeater.html" data-toggle="dropdown"><i
                                    class="la la-repeat"></i>Form Repeater</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link"
                        href="#" data-toggle="dropdown"><i class="la la-table"></i><span>Tables</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-table"></i>Bootstrap Tables</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="table-basic.html"
                                        data-toggle="dropdown">Basic Tables</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="table-border.html"
                                        data-toggle="dropdown">Table Border</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="table-sizing.html"
                                        data-toggle="dropdown">Table Sizing</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="table-styling.html"
                                        data-toggle="dropdown">Table Styling</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="table-components.html"
                                        data-toggle="dropdown">Table Components</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-th"></i>DataTables</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="dt-basic-initialization.html"
                                        data-toggle="dropdown">Basic Initialisation</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="dt-advanced-initialization.html"
                                        data-toggle="dropdown">Advanced initialisation</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="dt-styling.html"
                                        data-toggle="dropdown">Styling</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="dt-data-sources.html"
                                        data-toggle="dropdown">Data Sources</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="dt-api.html"
                                        data-toggle="dropdown">API</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-th-large"></i>DataTables Ext.</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="dt-extensions-autofill.html"
                                        data-toggle="dropdown">AutoFill</a>
                                </li>
                                <li class="dropdown " data-menu=""><a
                                        class="dropdown-item dropdown-toggle" href="#"
                                        data-toggle="dropdown">Buttons</a>
                                    <ul class="dropdown-menu">
                                        <li data-menu=""><a class="dropdown-item"
                                                href="dt-extensions-buttons-basic.html" data-toggle="dropdown">Basic
                                                Buttons</a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item"
                                                href="dt-extensions-buttons-html-5-data-export.html"
                                                data-toggle="dropdown">HTML 5 Data Export</a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item"
                                                href="dt-extensions-buttons-flash-data-export.html"
                                                data-toggle="dropdown">Flash Data Export</a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item"
                                                href="dt-extensions-buttons-column-visibility.html"
                                                data-toggle="dropdown">Column Visibility</a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item"
                                                href="dt-extensions-buttons-print.html"
                                                data-toggle="dropdown">Print</a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item"
                                                href="dt-extensions-buttons-api.html" data-toggle="dropdown">API</a>
                                        </li>
                                    </ul>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                        href="dt-extensions-column-reorder.html" data-toggle="dropdown">Column
                                        Reorder</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                        href="dt-extensions-fixed-columns.html" data-toggle="dropdown">Fixed
                                        Columns</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="dt-extensions-key-table.html"
                                        data-toggle="dropdown">Key Table</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="dt-extensions-row-reorder.html"
                                        data-toggle="dropdown">Row Reorder</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="dt-extensions-select.html"
                                        data-toggle="dropdown">Select</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="dt-extensions-fix-header.html"
                                        data-toggle="dropdown">Fix Header</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="dt-extensions-responsive.html"
                                        data-toggle="dropdown">Responsive</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                        href="dt-extensions-column-visibility.html" data-toggle="dropdown">Column
                                        Visibility</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-th-list"></i>Handson Table</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="handson-table-appearance.html"
                                        data-toggle="dropdown">Appearance</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="handson-table-rows-columns.html"
                                        data-toggle="dropdown">Rows Columns</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="handson-table-rows-only.html"
                                        data-toggle="dropdown">Rows Only</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="handson-table-columns-only.html"
                                        data-toggle="dropdown">Columns Only</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                        href="handson-table-data-operations.html" data-toggle="dropdown">Data
                                        Operations</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                        href="handson-table-cell-features.html" data-toggle="dropdown">Cell
                                        Features</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="handson-table-cell-types.html"
                                        data-toggle="dropdown">Cell Types</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="handson-table-integrations.html"
                                        data-toggle="dropdown">Integrations</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="handson-table-utilities.html"
                                        data-toggle="dropdown">Utilities</a>
                                </li>
                            </ul>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item" href="table-jsgrid.html" data-toggle="dropdown"><i
                                    class="la la-table"></i>jsGrid</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link"
                        href="#" data-toggle="dropdown"><i class="la la-plus-square"></i><span>Add
                            Ons</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-edit"></i>Editors</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="editor-quill.html"
                                        data-toggle="dropdown">Quill</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="editor-ckeditor.html"
                                        data-toggle="dropdown">CKEditor</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="editor-summernote.html"
                                        data-toggle="dropdown">Summernote</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="editor-tinymce.html"
                                        data-toggle="dropdown">TinyMCE</a>
                                </li>
                                <li class="dropdown " data-menu=""><a
                                        class="dropdown-item dropdown-toggle" href="#"
                                        data-toggle="dropdown">Code Editor</a>
                                    <ul class="dropdown-menu">
                                        <li data-menu=""><a class="dropdown-item"
                                                href="code-editor-codemirror.html"
                                                data-toggle="dropdown">CodeMirror</a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="code-editor-ace.html"
                                                data-toggle="dropdown">Ace</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-calendar"></i>Pickers</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item"
                                        href="pickers-date-&amp;-time-picker.html" data-toggle="dropdown">Date &amp;
                                        Time Picker</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="pickers-color-picker.html"
                                        data-toggle="dropdown">Color Picker</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-code-fork"></i>jQuery UI</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="jquery-ui-interactions.html"
                                        data-toggle="dropdown">Interactions</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="jquery-ui-navigations.html"
                                        data-toggle="dropdown">Navigations</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="jquery-ui-date-pickers.html"
                                        data-toggle="dropdown">Date Pickers</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="jquery-ui-autocomplete.html"
                                        data-toggle="dropdown">Autocomplete</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="jquery-ui-buttons-select.html"
                                        data-toggle="dropdown">Buttons &amp; Select</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="jquery-ui-slider-spinner.html"
                                        data-toggle="dropdown">Slider &amp; Spinner</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="jquery-ui-dialog-tooltip.html"
                                        data-toggle="dropdown">Dialog &amp; Tooltip</a>
                                </li>
                            </ul>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item" href="add-on-block-ui.html" data-toggle="dropdown"><i
                                    class="la la-terminal"></i>Block UI</a>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item" href="add-on-image-cropper.html" data-toggle="dropdown"><i
                                    class="la la-crop"></i>Image Cropper</a>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item" href="add-on-drag-drop.html" data-toggle="dropdown"><i
                                    class="la la-mouse-pointer"></i>Drag &amp; Drop</a>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-cloud-upload"></i>File Uploader</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="file-uploader-dropzone.html"
                                        data-toggle="dropdown">Dropzone</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-calendar"></i>Event Calendars</a>
                            <ul class="dropdown-menu">
                                <li class="dropdown " data-menu=""><a
                                        class="dropdown-item dropdown-toggle" href="#"
                                        data-toggle="dropdown">Full Calendar</a>
                                    <ul class="dropdown-menu">
                                        <li data-menu=""><a class="dropdown-item"
                                                href="full-calender-basic.html" data-toggle="dropdown">Basic</a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item"
                                                href="full-calender-events.html" data-toggle="dropdown">Events</a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item"
                                                href="full-calender-advance.html" data-toggle="dropdown">Advance</a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item"
                                                href="full-calender-extra.html" data-toggle="dropdown">Extra</a>
                                        </li>
                                    </ul>
                                </li>
                                <li data-menu="">
                                    <a class="dropdown-item" href="calendars-clndr.html" data-toggle="dropdown"><i
                                            class="la la-calendar"></i>CLNDR</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-flag-o"></i>Internationalization</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="i18n-resources.html"
                                        data-toggle="dropdown">Resources</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="i18n-xhr-backend.html"
                                        data-toggle="dropdown">XHR Backend</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="i18n-query-string.html?lng=en"
                                        data-toggle="dropdown">Query String</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="i18n-on-init.html"
                                        data-toggle="dropdown">On Init</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="i18n-after-init.html"
                                        data-toggle="dropdown">After Init</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="i18n-fallback.html"
                                        data-toggle="dropdown">Fallback</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link"
                        href="#" data-toggle="dropdown"><i
                            class="la la-line-chart"></i><span>Charts</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-bar-chart"></i>google Charts</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="google-bar-charts.html"
                                        data-toggle="dropdown">Bar charts</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="google-line-charts.html"
                                        data-toggle="dropdown">Line charts</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="google-pie-charts.html"
                                        data-toggle="dropdown">Pie charts</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="google-scatter-charts.html"
                                        data-toggle="dropdown">Scatter charts</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="google-bubble-charts.html"
                                        data-toggle="dropdown">Bubble charts</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="google-other-charts.html"
                                        data-toggle="dropdown">Other charts</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-file-photo-o"></i>Echarts</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="echarts-line-area-charts.html"
                                        data-toggle="dropdown">Line &amp; Area charts</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="echarts-bar-column-charts.html"
                                        data-toggle="dropdown">Bar &amp; Column charts</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                        href="echarts-pie-doughnut-charts.html" data-toggle="dropdown">Pie &amp;
                                        Doughnut charts</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="echarts-scatter-charts.html"
                                        data-toggle="dropdown">Scatter charts</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="echarts-radar-chord-charts.html"
                                        data-toggle="dropdown">Radar &amp; Chord charts</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                        href="echarts-funnel-gauges-charts.html" data-toggle="dropdown">Funnel &amp;
                                        Gauges charts</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="echarts-combination-charts.html"
                                        data-toggle="dropdown">Combination charts</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="echarts-advance-charts.html"
                                        data-toggle="dropdown">Advance charts</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-area-chart"></i>Chartjs</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="chartjs-line-charts.html"
                                        data-toggle="dropdown">Line charts</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="chartjs-bar-charts.html"
                                        data-toggle="dropdown">Bar charts</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                        href="chartjs-pie-doughnut-charts.html" data-toggle="dropdown">Pie &amp;
                                        Doughnut charts</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="chartjs-scatter-charts.html"
                                        data-toggle="dropdown">Scatter charts</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="chartjs-polar-radar-charts.html"
                                        data-toggle="dropdown">Polar &amp; Radar charts</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="chartjs-advance-charts.html"
                                        data-toggle="dropdown">Advance charts</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-line-chart"></i>D3 Charts</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="d3-line-chart.html"
                                        data-toggle="dropdown">Line Chart</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="d3-bar-chart.html"
                                        data-toggle="dropdown">Bar Chart</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="d3-pie-chart.html"
                                        data-toggle="dropdown">Pie Chart</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="d3-circle-diagrams.html"
                                        data-toggle="dropdown">Circle Diagrams</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="d3-tree-chart.html"
                                        data-toggle="dropdown">Tree Chart</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="d3-other-charts.html"
                                        data-toggle="dropdown">Other Charts</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-indent"></i>C3 Charts</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="c3-line-chart.html"
                                        data-toggle="dropdown">Line Chart</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="c3-bar-pie-chart.html"
                                        data-toggle="dropdown">Bar &amp; Pie Chart</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="c3-axis-chart.html"
                                        data-toggle="dropdown">Axis Chart</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="c3-data-chart.html"
                                        data-toggle="dropdown">Data Chart</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="c3-grid-chart.html"
                                        data-toggle="dropdown">Grid Chart</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="c3-transform-chart.html"
                                        data-toggle="dropdown">Transform Chart</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="c3-other-charts.html"
                                        data-toggle="dropdown">Other Charts</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-pie-chart"></i>Chartist</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="chartist-line-charts.html"
                                        data-toggle="dropdown">Line charts</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="chartist-bar-charts.html"
                                        data-toggle="dropdown">Bar charts</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="chartist-pie-charts.html"
                                        data-toggle="dropdown">Pie charts</a>
                                </li>
                            </ul>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item" href="morris-charts.html" data-toggle="dropdown"><i
                                    class="la la-share-alt"></i>Morris Charts</a>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-bolt"></i>Flot Charts</a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="flot-line-charts.html"
                                        data-toggle="dropdown">Line charts</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="flot-bar-charts.html"
                                        data-toggle="dropdown">Bar charts</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="flot-pie-charts.html"
                                        data-toggle="dropdown">Pie charts</a>
                                </li>
                            </ul>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item" href="rickshaw-charts.html" data-toggle="dropdown"><i
                                    class="la la-bullseye"></i>Rickshaw Charts</a>
                        </li>
                        <li class="dropdown " data-menu="">
                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                    class="la la-map"></i>Maps</a>
                            <ul class="dropdown-menu">
                                <li class="dropdown " data-menu=""><a
                                        class="dropdown-item dropdown-toggle" href="#"
                                        data-toggle="dropdown">google Maps</a>
                                    <ul class="dropdown-menu">
                                        <li data-menu=""><a class="dropdown-item" href="gmaps-basic-maps.html"
                                                data-toggle="dropdown">Maps</a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="gmaps-services.html"
                                                data-toggle="dropdown">Services</a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="gmaps-overlays.html"
                                                data-toggle="dropdown">Overlays</a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="gmaps-routes.html"
                                                data-toggle="dropdown">Routes</a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="gmaps-utils.html"
                                                data-toggle="dropdown">Utils</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown " data-menu=""><a
                                        class="dropdown-item dropdown-toggle" href="#"
                                        data-toggle="dropdown">Vector Maps</a>
                                    <ul class="dropdown-menu">
                                        <li class="dropdown " data-menu=""><a
                                                class="dropdown-item dropdown-toggle" href="#"
                                                data-toggle="dropdown">jQuery Mapael</a>
                                            <ul class="dropdown-menu">
                                                <li data-menu=""><a class="dropdown-item"
                                                        href="vector-maps-mapael-basic.html"
                                                        data-toggle="dropdown">Basic Maps</a>
                                                </li>
                                                <li data-menu=""><a class="dropdown-item"
                                                        href="vector-maps-mapael-advance.html"
                                                        data-toggle="dropdown">Advance Maps</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item"
                                                href="vector-maps-jvector.html" data-toggle="dropdown">jVector
                                                Map</a>
                                        </li>
                                        <li data-menu=""><a class="dropdown-item" href="vector-maps-jvq.html"
                                                data-toggle="dropdown">JQV Map</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li> --}}
        </ul>
    </div>
</div>
