<header id="pageTop" class="header">

    <!-- TOP INFO BAR -->
    <div class="top-info-bar">
        <div class="container">
            <div class="top-bar-right">
                <ul class="list-inline">
                    @if(get_general_value('whatsapp_number'))
                        <li>
                            <a href="https://wa.me/{{ get_general_value('whatsapp_number') }}">
                                <i class="fab fa-whatsapp" aria-hidden="true"></i>
                            </a>
                        </li>
                    @endif
                
                    @if(get_social_value('facebook'))
                        <li>
                            <a href="{{ get_social_value('facebook') }}">
                                <i class="fab fa-facebook" aria-hidden="true"></i>
                            </a>
                        </li>
                    @endif
                
                    @if(get_social_value('instagram'))
                        <li>
                            <a href="{{ get_social_value('instagram') }}">
                                <i class="fab fa-instagram" aria-hidden="true"></i>
                            </a>
                        </li>
                    @endif
                
                    @if(get_social_value('tiktok'))
                        <li>
                            <a href="{{ get_social_value('tiktok') }}">
                                <i class="fab fa-tiktok" aria-hidden="true"></i>
                            </a>
                        </li>
                    @endif
                    @if(get_social_value('twitter'))
                    <li>
                        <a href="{{ get_social_value('twitter') }}">
                            <i class="fab fa-twitter" aria-hidden="true"></i>
                        </a>
                    </li>
                @endif
                </ul>
                
            </div>
        </div>
    </div>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-md main-nav navbar-light">
        <div class="container">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="/"><img class="lazyestload"
                    data-src="{{ asset('uploads/' . get_general_value('website_logo')) }}"
                    src="{{ asset('uploads/' . get_general_value('website_logo')) }}" alt="logo"></a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item @if (request()->is('/')) active @endif">
                        <a class="nav-link" href="/">الرئيسية <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item @if (request()->routeIs('products')) active @endif">
                        <a class="nav-link" href="{{ route('products') }}">المنتجات <span
                                class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item @if (request()->routeIs('services')) active @endif">
                        <a class="nav-link" href="{{ route('services') }}">الخدمات <span
                                class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item @if (request()->routeIs('packegs')) active @endif">
                        <a class="nav-link" href="{{ route('packegs') }}">الباقات <span
                                class="sr-only">(current)</span></a>
                    </li>
                    <li id="courses-nav-item" class="nav-item @if (
                        (request()->routeIs('home') &&
                            request()->hasHeader('X-Requested-With') &&
                            request()->header('X-Requested-With') === 'XMLHttpRequest') ||
                            (request()->is('/') && isset($_SERVER['HTTP_REFERER']) && str_contains($_SERVER['HTTP_REFERER'], '#courses'))) active @endif">

                        @if (Route::currentRouteName() != 'home')
                            <a class="nav-link" href="{{ route('home') }}#courses">الدورات <span
                                    class="sr-only">(current)</span></a>
                        @else
                            <a class="nav-link" href="#courses">الدورات <span class="sr-only">(current)</span></a>
                        @endif
                    </li>
                    <li class="nav-item @if (request()->routeIs('contact-us')) active @endif">
                        <a class="nav-link" href="{{ route('contact-us') }}">تواصل معنا <span
                                class="sr-only">(current)</span></a>
                    </li>
                </ul>
            </div>

            <div class="cart_btn">
                <a href="{{ route('cart.index') }}"><i class="fas fa-cart-shopping" aria-hidden="true"></i><span
                        class="badge">{{ count(session('cart', [])) }}</span></a>
            </div>
            <!-- header search ends-->
        </div>
    </nav>

</header>
