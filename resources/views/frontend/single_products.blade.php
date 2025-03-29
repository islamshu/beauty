@extends('layouts.frontend')
@section('content')
    <section class="clearfix singleProduct">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="singleIamge">
                        <img src="{{ asset('uploads/' . $product->image) }}" data-src="{{ asset('uploads/' . $product->image) }}"
                            alt="Image Single Product" class="img-responsive lazyestload">
                    </div>
                </div>
                @php
                    $title = $product->title;
                    $shareText = $product->title;

                @endphp
                <div class="col-md-6">
                    <div class="singleProductInfo">
                        <h2>{{ $product->title }}</h2>
                        <h3>{{ $product->price_after_discount }} ₪ <del>{{ $product->price_before_discount }} ₪</del>
                        </h3>
                        <p>{!! $product->small_description !!}</p>

                        <div class="finalCart">
                            <a href="{{route('cart.add',$product->id)}}" class="btn btn-primary"><i class="fa fa-shopping-basket"
                                    aria-hidden="true"></i>Add to cart</a>
                        </div>



                        <ul class="list-inline shareSocial">
                            <li>Share:</li>
                            <!-- Facebook Share -->
                            <li>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                    target="_blank">
                                    <i class="fa fa-facebook" aria-hidden="true"></i>
                                </a>
                            </li>

                            <!-- Twitter Share -->
                            <li>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($shareText ?? 'Check this out!') }}"
                                    target="_blank">
                                    <i class="fa fa-twitter" aria-hidden="true"></i>
                                </a>
                            </li>

                            <!-- Pinterest Share -->
                            <li>
                                <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&media={{ urlencode($imageUrl ?? '') }}&description={{ urlencode($shareText ?? '') }}"
                                    target="_blank">
                                    <i class="fa fa-pinterest-p" aria-hidden="true"></i>
                                </a>
                            </li>

                            <!-- LinkedIn Share -->
                            <li>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($title ?? '') }}&summary={{ urlencode($shareText ?? '') }}"
                                    target="_blank">
                                    <i class="fa fa-linkedin" aria-hidden="true"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="tabCommon tabOne singleTab">
                        <ul class="nav nav-tabs">
                            <li><a class="active" data-toggle="tab" href="#details">التفاصيل</a></li>
                        </ul>

                        <div class="tab-content patternbg">
                            <div id="details" class="tab-pane show fade in active">
                                <h4>وصف المنتج</h4>
                                {!! $product->long_description !!}
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="relatedTitle">
                        <h2>منتجاتذات صلة</h2>
                    </div>
                </div>
            </div>

            <!-- resources/views/products/show.blade.php -->

            @if ($product->relatedProducts->count() > 0)
                <div class="related-products">
                    <h3>منتجات ذات صلة</h3>
                    <div class="row">
                        @foreach ($product->relatedProducts as $related)
                            <div class="col-md-6 col-lg-4 col-xl-3 mb-4">

                                <div class="produtSingle">
                                    <div class="produtImage">
                                        <img src="{{ asset('uploads/' . $related->image) }}" alt="{{ $related->title }}"
                                            class="img-fluid">
                                        <div class="productMask">
                                            <ul class="list-inline productOption">
                                                <li>
                                                    <a href="{{ route('cart.add', $related->id) }}">
                                                        <i class="fas fa-shopping-cart"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="productCaption">
                                        <h2 style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            <a
                                                href="{{ route('product.details', $related->id) }}">{{ $related->title }}</a>
                                        </h2>
                                        <h2 class="price">${{ $related->price_after_discount }}</h2>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
