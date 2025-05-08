@extends('layouts.frontend')
@section('style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-quantity {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 5px 10px;
            cursor: pointer;
            width: 50px !important;
        }

        .btn-quantity:hover {
            background-color: #e9ecef;
        }

        .quantity {
            font-weight: bold;
        }

        .empty-cart-message {
            text-align: center;
            padding: 50px;
            font-size: 2rem;
            color: #666;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            /* Stack text vertically */
        }
    </style>
@endsection
@section('content')
    <section class="clearfix orderArea">
        <div class="container">
            <div class="row">
                @if (count($cart) > 0)
                    <div class="col-lg-8">
                        <div class="panel panel-default cartInfo">
                            <div class="panel-heading patternbg">طلباتك</div>
                            <div class="panel-body tableArea mb-4 mb-lg-0">
                                <div>
                                    <table class="table">
                                        <tbody>
                                            @foreach ($cart as $id => $item)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('product.details', $id) }}" class="cartImage">
                                                            <img src="{{ asset('uploads/' . $item['image']) }}"
                                                                style="max-width: 70%; height: 50%; margin-top: 15%;"
                                                                alt="صورة المنتج">
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a class="text-wrap"
                                                            href="{{ route('product.details', $id) }}">{{ $item['name'] }}</a>
                                                        <br>
                                                        <div class="quantity-control">
                                                            <button class="btn btn-sm btn-quantity minus"
                                                                data-id="{{ $id }}">-</button>
                                                            <span class="quantity">{{ $item['quantity'] }}</span>
                                                            <button class="btn btn-sm btn-quantity plus"
                                                                data-id="{{ $id }}">+</button>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="price"
                                                            id="price-{{ $id }}">{{ $item['price'] * $item['quantity'] }}
                                                            ₪</span>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="close" aria-label="Close">
                                                                <span aria-hidden="true" class="hidden-xs">× </span>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="panel panel-default cartInfo">
                            <div class="panel-heading patternbg">الإجمالي <span class="pull-right"
                                    id="total">{{ $total }} ₪</span></div>
                            <button type="button" class="btn first-btn mt-1" style="background-color: #d63384;width: 100%;"
                                data-bs-toggle="modal" data-bs-target="#checkoutModal">
                                إتمام الطلب
                            </button>
                        </div>
                    </div>
                @else
                    <div class="col-md-12 empty-cart-message">
                        <p>السلة فارغة</p>
                        <p>لا يوجد منتجات في سلة التسوق الخاصة بك. ابدأ بالتسوق الآن!</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- مودال إتمام الطلب -->
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
                    
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customer_name" class="form-label">الاسم الكامل</label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                            </div>
                    
                            <div class="col-md-6 mb-3">
                                <label for="customer_phone">رقم الهاتف</label>
                                <div class="input-group input-group-sm">
                                    <input type="tel" class="form-control" id="customer_phone" name="customer_phone"
                                        placeholder="590000000" pattern="[0-9]{9}" title="يجب إدخال 9 أرقام بالضبط"
                                        maxlength="9" required>
                                    <select class="form-control" name="country_code" id="country_code" style="max-width: 80px;" required>
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
                                        <option data-price="{{$item->price}}" value="{{ $item->id }}">{{ $item->name }} - ({{ $item->price }} شيكل)</option>
                                    @endforeach
                                </select>
                                <div id="delivery_note" class="mt-2 text-info" style="display:none;"></div>
                                <p><strong>السعر الإجمالي:</strong> <span id="total_price_display">{{ $total }}</span> شيكل</p>
                                <input type="hidden" id="original_total" value="{{ $total }}">
                            </div>
                    
                            <div class="col-md-12 mb-3">
                                <label for="customer_address" class="form-label">العنوان بالتفصيل</label>
                                <input type="text" class="form-control" id="customer_address" name="customer_address" required>
                            </div>
                        </div>
                    
                        <button style="width: 100%" id="submitOrderBtn" class="btn btn-primary cart-btn">
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
                $('#delivery_note').text('ملاحظة: سيتم زيادة سعر التوصيل بقيمة ' + deliveryPrice + ' شيكل.').show();
        
                // تحديث السعر الإجمالي الظاهر
                var newTotal = originalTotal + deliveryPrice;
                $('#total_price_display').text(newTotal.toFixed(2));
            });
        });
        </script>
    <script>
        $(document).ready(function() {
            // زيادة الكمية
            $('.plus').click(function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                updateQuantity(id, 'increase');
            });

            // تقليل الكمية
            $('.minus').click(function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                updateQuantity(id, 'decrease');
            });

            // تحديث الكمية باستخدام AJAX
            // تحديث الكمية باستخدام AJAX
            function updateQuantity(id, action) {
                let quantityElement = $(`button[data-id="${id}"]`).siblings('.quantity');
                let priceElement = $(`#price-${id}`);
                let currentQuantity = parseInt(quantityElement.text());
                let pricePerUnit = parseFloat(priceElement.text().replace(/[^0-9.]/g, '')) / currentQuantity;
                let newQuantity = action === 'increase' ? currentQuantity + 1 : currentQuantity - 1;

                if (newQuantity < 1) {
                    newQuantity = 1; // التأكد من أن الكمية لا تقل عن 1
                }

                $.ajax({
                    url: "{{ route('cart.update', ':id') }}".replace(':id',
                    id), // Ensure the correct id is passed
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        quantity: newQuantity,
                    },
                    success: function(response) {
                        if (response.success) {
                            quantityElement.text(newQuantity); // تحديث الكمية في الواجهة

                            // تحديث سعر المنتج بناءً على الكمية الجديدة
                            let newPrice = pricePerUnit * newQuantity;
                            priceElement.text(newPrice.toFixed(2) + ' ₪');

                            // تحديث إجمالي السعر للسلة بالكامل
                            updateTotalPrice();
                        }
                    },
                    error: function() {
                        alert('حدث خطأ أثناء تحديث الكمية.');
                    }
                });
            }


            // تحديث الإجمالي العام لكل المنتجات
            function updateTotalPrice() {
                let total = 0;
                $('.price').each(function() {
                    total += parseFloat($(this).text().replace(/[^0-9.]/g, ''));
                });

                $('#total').text(total.toFixed(2) + ' ₪');
            }
        });
    </script>
@endsection
