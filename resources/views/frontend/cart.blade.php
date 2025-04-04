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
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">الاسم الكامل</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer_phone" class="form-label">رقم الهاتف</label>
                            <input type="text" class="form-control" id="customer_phone" name="customer_phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer_id" class="form-label">رقم الهوية</label>
                            <input type="text" class="form-control" id="customer_id" name="customer_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer_address" class="form-label">العنوان </label>
                            <input type="text" class="form-control" id="customer_address" name="customer_address"
                                required>
                        </div>
                        <button style="width: 100%" class="btn btn-primary cart-btn " style="padding: 20px"
                            data-toggle="modal" data-target="#cartModal">
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

                $('#total').text(total.toFixed(2) + ' $');
            }
        });
    </script>
@endsection
