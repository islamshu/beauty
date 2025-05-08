<!-- قسم المنتجات -->
<section class="clearfix productSection">
    <div class="container">
        <div class="secotionTitle">
            <h2><span>طبيعي </span>منتجاتنا</h2>
        </div>
        <style>
            .productCaption h2 {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
        </style>

<div id="productCarousel" class="carousel carouselpro slide mt-5" data-ride="carousel">
    <!-- Slides -->
    <div class="carousel-inner">
        @php
        function isMobile2() {
            return preg_match("/(android|webos|avantgo|iphone|ipad|ipod|blackberry|iemobile|bolt|boost|cricket|docomo|fone|hiptop|mini|opera mini|kitkat|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
        }
        
        $itemsPerSlide = isMobile2() ? 1 : 4;
    @endphp

        <!-- Loop through the products and create slides -->
    @foreach($products->chunk($itemsPerSlide) as $chunk)
        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
            <div class="row">
                @foreach($chunk as $product)
                <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-4">
                    <div class="produtSingle">
                        <div class="produtImage">
                            <img src="{{ asset('uploads/' . $product->image) }}" alt="{{ $product->title }}" class="img-fluid">
                            <div class="productMask">
                                <ul class="list-inline productOption">
                                    <li>
                                        <a href="{{ route('cart.add', $product->id) }}">
                                            <i class="fas fa-shopping-cart"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="productCaption">
                            <h2 class="productTitle">
                                <a href="{{ route('product.details', $product->id) }}">{{ $product->title }}</a>
                            </h2>
                            <h2 class="price"><small>₪</small> {{ $product->price_after_discount }}</h2>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    <!-- Navigation -->
    <a class="carousel-control-prev" href="#productCarousel" role="button" data-slide="prev">
        <span  class="angle-right"><i class="fa fa-angle-left" aria-hidden="true"></i>
        </span>
        
        <span class="sr-only">السابق</span>
    </a>
   
    
    <a class="carousel-control-next" href="#productCarousel" role="button" data-slide="next">
        <span  class="angle-left"><i class="fa fa-angle-right" aria-hidden="true"></i>
        </span>        <span class="sr-only">التالي</span>
    </a>
    
    <!-- Pagination indicators -->
    <ol class="carousel-indicators">
        @foreach($products->chunk($itemsPerSlide)  as $index => $chunk)
        <li data-target="#productCarousel" data-slide-to="{{ $index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
        @endforeach
    </ol>
</div>

<div class="more-services">
    <a href="{{route('products')}}" class="more-services-btn">المزيد من المنتجات</a>
</div>

<style>
    .carouselpro {
        height: 330px;
    }
    .carousel-indicators {
        bottom: -10px;
    }
    .carousel-indicators li {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #ccc;
        border: none;
        margin: 0 5px;
    }
    .carousel-indicators .active {
        background: #007bff;
    }
    .productCaption h2 {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
    </div>
</section>