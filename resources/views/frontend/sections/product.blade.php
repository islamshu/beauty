<!-- قسم المنتجات -->
<section class="clearfix productSection">
    <div class="container">
        <div class="secotionTitle">
            <h2><span>طبيعي </span>منتجاتنا</h2>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="owl-carousel productSlider">
                    @foreach ($products as $product)
                        <div class="slide">
                            <div class="row">
                                <!-- صورة المنتج -->
                                <div class="col-md-6 order">
                                    <div class="productImage">
                                        <img src="{{ asset('uploads/' . $product->image) }}" data-src="{{ asset('uploads/' . $product->image) }}" alt="{{ $product->title }}" class="img-responsive lazyestload">
                                        <a href="{{ route('cart.add', $product->id) }}"><i class="fa fa-shopping-basket" aria-hidden="true"></i></a>
                                    </div>
                                </div>

                                <!-- معلومات المنتج -->
                                <div class="col-md-6">
                                    <div class="productInfo">
                                        <h3>{{ $product->title }}</h3>
                                        <h4>{{ number_format($product->price_after_discount, 2) }} ريال <del>{{ number_format($product->price_before_discount, 2) }} ريال</del></h4>
                                        <ul class="list-inline rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <li>
                                                    @if ($i <= rand(3.5 , 5))
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    @else
                                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                                    @endif
                                                </li>
                                            @endfor
                                        </ul>
                                        <p>{{ $product->small_description }}</p>
                                        <a href="" class="btn btn-primary first-btn">قراءة المزيد</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>