<!-- قسم المنتجات -->
<section class="clearfix productSection">
    <div class="container">
        <div class="secotionTitle">
            <h2><span>طبيعي </span>منتجاتنا</h2>
        </div>

        <div id="productCarousel" class="carousel slide mt-5" data-ride="carousel">
            <!-- Slides -->
            <div class="carousel-inner">
                @foreach($products as $product)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="row justify-content-center">
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
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
                                    <h2 style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        <a href="{{ route('product.details', $product->id) }}">{{ $product->title }}</a>
                                    </h2>
                                    <h2 class="price"><small>₪</small> {{ $product->price_after_discount }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Navigation arrows -->
            <a class="carousel-control-prev" href="#productCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#productCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>

            <!-- Pagination bullets -->
            <ol class="carousel-indicators">
                @foreach($products as $index => $product)
                <li data-target="#productCarousel" data-slide-to="{{ $index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                @endforeach
            </ol>
        </div>

        <style>
            .carousel-indicators {
                bottom: -25px;
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
            
            /* جعل الكاروسيل يأخذ عرض الصفحة بالكامل على الجوال */
            @media (max-width: 767px) {
                .carousel-inner {
                    width: 100%;
                }
                .produtSingle {
                    margin: 0 auto;
                    max-width: 80%;
                }
                .carousel-control-prev, 
                .carousel-control-next {
                    width: 30px;
                }
            }
        </style>
    </div>
</section>