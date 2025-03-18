
<header id="pageTop" class="header">

    <!-- TOP INFO BAR -->
    <div class="top-info-bar">
        <div class="container">
            <div class="top-bar-right">
                <ul class="list-inline">
                    <li><a href="#"><i class="fa fa-envelope" aria-hidden="true"></i> {{get_general_value('website_email')}}</a></li>
                    <li><span><i class="fa fa-phone" aria-hidden="true"></i>{{get_general_value('whatsapp_number')}}</span></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-md main-nav navbar-light">
        <div class="container">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
  </button>

            <a class="navbar-brand" href="/"><img class="lazyestload" data-src="{{asset('uploads/'.get_general_value('website_logo'))}}" src="{{asset('uploads/'.get_general_value('website_logo'))}}" alt="logo"></a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">الرئيسية <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="{{route('products')}}">المنتجات <span class="sr-only">(current)</span></a>
                    </li>
                    @if(Route::currentRouteName() != 'home')

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('home')}}#courses">الدورات <span class="sr-only">(current)</span></a>
                    </li>
                    @else
                    <li class="nav-item ">
                        <a class="nav-link" href="#courses">الدورات <span class="sr-only">(current)</span></a>
                    </li>
                    @endif

                    
                </ul>
            </div>

            <div class="cart_btn">
                <a href="{{ route('cart.index') }}"><i class="fa fa-shopping-basket" aria-hidden="true"></i><span class="badge">{{ count(session('cart', [])) }}</span></a>
            </div>
            <!-- header search ends-->
        </div>
    </nav>

</header>