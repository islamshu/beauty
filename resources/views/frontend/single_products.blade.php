@extends('layouts.frontend')
@section('style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* تحسين مظهر العناوين */
        .product-title {
            font-size: 1.6rem;
            /* تقليل الحجم */
            font-weight: bold;
            color: #333;
            margin-bottom: 3px !important;
            /* تقليل المسافة بين العنوان والسعر */
        }

        .total_price_display {
            text-align: center;
        }

        .total_price_display p {
            color: red;
        }

        /* تعديل تنسيق السعر */
        .price {
            font-size: 1.4rem !important;
            /* تقليل الحجم */
            font-weight: 600 !important;
            color: #f44336 !important;
            margin-bottom: 3px !important;
        }

        .price del {
            font-size: 1.2rem;
            color: #757575;
            text-decoration: line-through;
        }

        /* تحسين وصف المنتج */
        .product-description {
            font-size: 1rem;
            /* تقليل حجم النص */
            color: #555;
            line-height: 1.5;
            margin-bottom: 10px !important;
            text-align: right;
        }

        /* تخصيص أزرار السلة */
        .finalCart .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 12px;
            font-size: 1.2rem;
            width: 100%;
            text-transform: uppercase;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .finalCart .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        /* تحسين مظهر المشاركات الاجتماعية */
        .shareSocial {
            margin-top: 5px;
            font-size: 1.4rem;
            /* تقليل حجم الأيقونات */
            list-style: none;
            padding: 0;
        }

        .shareSocial li {
            display: inline-block;
            margin-right: 10px;
            /* تقليل المسافة بين الأيقونات */
        }

        .shareSocial li a {
            color: #333;
            transition: color 0.3s ease;
        }

        .shareSocial li a:hover {
            color: #007bff;
        }

        /* تصميم للمنتجات ذات الصلة */
        .related-products h3 {
            font-size: 1.6rem;
            color: #333;
            margin-bottom: 5px;
            /* تقليل المسافة */
            text-align: right;
        }

        .produtSingle {
            border: 1px solid #e0e0e0;
            padding: 10px;
            /* تقليل padding */
            border-radius: 3px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .produtSingle:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .produtImage img {
            max-width: 90%;
            /* تقليل حجم الصورة */
            max-height: 70%;
            border-radius: 3px;
            transition: transform 0.3s ease;
            display: block;
            margin: 0 auto;
            padding-top: 30%
                /* توسيط الصورة */
        }

        .produtImage img:hover {
            transform: scale(1.05);
        }

        .productCaption {
            text-align: center;
            padding: 3px 0;
        }

        .productCaption .product-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 3px !important;
            /* تقليل المسافة */
        }

        .productCaption .price {
            font-size: 1.2rem !important;
            color: #f44336 !important;
            font-weight: bold !important;
        }

        img.lazyestload {
            width: 100%;
            -webkit-filter: blur(0px) !important;
            filter: blur(0px) !important;
        }

        .product-image-wrapper {
            margin-top: 17%;
            border: 1px solid #ccc;
            /* إطار خفيف */
            padding: 6px;
            border-radius: 6px;
            background-color: #fff;
            max-width: 100%;
            display: inline-block;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
            /* ظل خفيف */
        }

        .product-image-adjusted {
            max-width: 100%;
            /* يُظهر الصورة بكامل عرض الحاوية */
            width: 400px !important;
            /* حجم مناسب - عدله حسب تصميمك */
            height: auto;
        }
    </style>
@endsection
@section('content')
    <section class="singleProduct">
        <div class="container">
            <div class="row">
                <!-- صورة المنتج -->
                <div class="col-md-4 mb-4">
                    <div class="product-image-wrapper text-center">
                        <img src="{{ asset('uploads/' . $product->image) }}" alt="Image Single Product"
                            class="img-fluid product-image-adjusted lazyestload">
                    </div>


                </div>

                <div class="col-md-6">
                    <div class="singleProductInfo">
                        <h2 class="product-title">{{ $product->title }}</h2>
                        <h3 class="price">
                            {{ $product->price_after_discount }} ₪
                            <del>{{ $product->price_before_discount }} ₪</del>
                        </h3>
                        <p class="product-description">{!! $product->small_description !!}</p>

                        <div class="finalCart mt-3 d-flex gap-2">
                            <a href="{{ route('cart.add', $product->id) }}"
                                class="btn btn-primary w-50 d-flex align-items-center justify-content-center">
                                <i class="fa fa-shopping-cart me-1"></i> اضف الى السلة
                            </a>

                            <button type="button"
                                class="btn btn-success w-50 d-flex align-items-center justify-content-center"
                                data-bs-toggle="modal" data-bs-target="#checkoutModal">
                                <i class="fa fa-bolt me-1"></i> اطلبه الان
                            </button>
                        </div>



                    </div>
                </div>
            </div>

            <!-- تفاصيل المنتج -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="tabCommon tabOne singleTab">


                        <div class="tab-content patternbg mt-3">
                            <div id="details" class="tab-pane show fade in active">
                                <h4>وصف المنتج</h4>
                                {!! $product->long_description !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- المنتجات ذات الصلة -->
            @if ($relatedProducts->count() > 0)
                <div class="related-products mt-4">
                    <h3>منتجات ذات صلة</h3>
                    <div class="row">
                        @foreach ($relatedProducts as $related)
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-4">
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
                                        <h2 class="productTitle">
                                            <a href="{{ route('product.details', $related->id) }}">{{ $related->title }}</a>
                                        </h2>
                                        <h2 class="price"><small>₪</small> {{ $related->price_after_discount }}</h2>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

    </section>
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkoutModalLabel">إتمام الطلب</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <form id="checkoutForm">
                        @csrf
                        <input type="hidden" name="product_single" value="{{ $product->id }}" id="product_single">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customer_name" class="form-label">الاسم الكامل</label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="customer_phone">رقم الهاتف</label>
                                <div class="input-group input-group-sm">
                                    <input type="tel" class="form-control" id="phoneNumber" placeholder="0590000000"
                                        name="phone" pattern="^0[0-9]{9}$"
                                        title="يجب أن يبدأ رقم الهاتف بـ 0 ويتكون من 10 أرقام" maxlength="10" required>
                                    <select class="form-control" name="country_code" id="country_code"
                                        style="max-width: 80px;" required>
                                        <option value="+970">970</option>
                                        <option value="+972">972</option>
                                    </select>
                                </div>
                                <span class="text-danger error-customer_phone"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="customer_area" class="form-label">المنطقة والتوصيل</label>
                                <select name="area" class="form-control" required id="customer_area">
                                    <option value="" disabled selected>اختر المنطقة</option>
                                    @foreach (App\Models\Area::get() as $item)
                                        <option data-price="{{ $item->price }}" value="{{ $item->id }}">
                                            {{ $item->name }} - ({{ $item->price }} شيكل)</option>
                                    @endforeach
                                </select>
                                <div id="delivery_note" class="mt-2 text-dark" style="display:none;"></div>
                                <div class="total_price_display">
                                    <p><strong>السعر الإجمالي: <span
                                                id="total_price_display">{{ $product->price_after_discount }}
                                                شيكل</span></strong> </p>
                                    <input type="hidden" id="original_total"
                                        value="{{ $product->price_after_discount }}">
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="customer_address" class="form-label">العنوان بالتفصيل</label>
                                <input type="text" class="form-control" id="customer_address" name="customer_address"
                                    required>
                            </div>
                        </div>

                        <button style="width: 100%" id="submitProductBtn" class="btn btn-primary cart-btn">
                            <i class="fa fa-user-plus"></i> اتمام الطلب
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#customer_area').change(function() {
                var selectedOption = $(this).find('option:selected');
                var deliveryPrice = parseFloat(selectedOption.data('price')) || 0;
                var originalTotal = parseFloat($('#original_total').val()) || 0;

                // إظهار الملاحظة
                $('#delivery_note').text(' ملاحظة: سيتم إضافة سعر التوصيل بقيمة ' + deliveryPrice +
                    ' شيكل.').show();

                // تحديث السعر الإجمالي الظاهر
                var newTotal = originalTotal + deliveryPrice;
                $('#total_price_display').text(newTotal.toFixed(2) + ' شيكل');
            });
        });
    </script>
@endsection
