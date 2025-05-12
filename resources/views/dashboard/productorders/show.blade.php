@extends('layouts.master')

@section('title', 'تفاصيل الطلب')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('تفاصيل الطلب ') }}</h3>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('طلبات المنتجات') }}</h4>
                </div>
                <div class="card-body">
                    @include('dashboard.inc.alerts')

                    <h2>تفاصيل الطلب #{{ $order->id }}</h2>

                    <div class="card">
                        <div class="card-body">
                            <h5>معلومات العميل</h5>
                            <div class="mt-2">
                                <p><strong>تاريخ الطلب:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>الاسم:</strong> {{ $order->customer_name }}</p>
                                    <p><strong >الهاتف:</strong> {{ $order->customer_phone }}</p>
                                    <p><strong>منطقة التوصيل:</strong> {{ $order->area_price->name }}</p>

                                    <p><strong>تغير الحالة:</strong></p>

                                    <select id="status-select" class="form-control" style="max-width: 200px;">
                                        <option value="جاري المتابعة" {{ $order->status == 'جاري المتابعة' ? 'selected' : '' }}>جاري المتابعة</option>
                                        <option value="تم الارسال" {{ $order->status == 'تم الارسال' ? 'selected' : '' }}>تم الارسال</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>العنوان:</strong> {{ $order->customer_address }}</p>
                                    <p><strong>سعر اجمالي المنتجات :</strong> {{ $order->total_price }} شيكل</p>
                                    <p><strong>سعر  التوصيل :</strong> {{ $order->area_price->price }} شيكل</p>
                                    <p><strong>الاجمالي  :</strong> {{ $order->area_price->price +  $order->total_price }} شيكل</p>

                                </div>

                                
                                
                            </div>
                          

                         
                         

                            <div class="mt-3 d-flex  align-items-center">
                                <div>
                                    <strong>الحالة الحالية:</strong> 
                                    <span id="order-status" class="badge badge-{{ 
                                        $order->status == 'جاري المتابعة' ? 'info' : 
                                        ($order->status == 'تم الارسال' ? 'success' : 'warning') }}">
                                        {{ $order->status }}
                                    </span>
                                </div>

                                
                            </div>
                        </div>
                    </div>

                    <h5 class="mt-4">المنتجات المطلوبة</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>الصورة</th>
                                <th>المنتج</th>
                                <th>الكمية</th>
                                <th>السعر</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td><img src="{{ asset('uploads/' . $item->product->image) }}" width="50"></td>
                                    <td>{{ $item->product->title }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->price }} شيكل</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">رجوع</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#status-select').change(function() {
            var orderId = {{ $order->id }};
            var status = $(this).val();

            $.ajax({
                url: "{{ route('orders.update.status', ['order' => '__ID__']) }}".replace('__ID__', orderId),
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    status: status
                },
                success: function () {
                    let badge = $('#order-status');
                    badge.text(status);
                    badge.removeClass('badge-info badge-success badge-warning');

                    if (status === 'تم الارسال') {
                        badge.addClass('badge-success');
                    } else if (status === 'جاري المتابعة') {
                        badge.addClass('badge-info');
                    } else {
                        badge.addClass('badge-warning');
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'تم التحديث',
                        text: 'تم تغيير حالة الطلب بنجاح'
                    });
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'حدث خطأ أثناء تغيير الحالة'
                    });
                }
            });
        });
    });
</script>
@endsection
