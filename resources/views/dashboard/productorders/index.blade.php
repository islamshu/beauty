@extends('layouts.master')
@section('title','طلبات المنتجات')
 
@section('content')
    <div class="app-content content">

        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('طلبات المنتجات') }}</h3>
                </div>
            </div>
            <div class="content-body">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('طلبات المنتجات') }}</h4>
      
                    </div>
                    <div class="card-body">
                        @include('dashboard.inc.alerts')

                        <table class="table ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم العميل</th>
                                    <th>رقم الهاتف</th>
                                    <th>المنطقة</th>

                                    <th>الاجمالي (شامل التوصيل) </th>
                                    <th>تاريخ الطلب</th>
                                    <th>حالة الطلب</th>

                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $order->customer_name }}</td>
                                        <td>{{ $order->customer_phone }}</td>

                                        <td>{{ $order->area_price->name }} </td>
                                        <td>{{ $order->total_price +  $order->area_price->price   }} شيكل</td>
                                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <select name="status" class="form-control order-status-select" 
                                                    data-id="{{ $order->id }}" style="color: {{ $order->status == 'تم الارسال' ? 'green' : 'orange' }}">
                                                <option value="جاري المتابعة" {{ $order->status == 'جاري المتابعة' ? 'selected' : '' }}>جاري المتابعة</option>
                                                <option value="تم الارسال" {{ $order->status == 'تم الارسال' ? 'selected' : '' }}>تم الارسال</option>
                                            </select>
                                        </td>
                                        
                                        <td>
                                            <a href="{{ route('orders.show', $order->id) }}"
                                                class="btn btn-info btn-sm">عرض</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $orders->links() }} <!-- روابط التقسيم -->
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).on('change', '.order-status-select', function () {
            const select = $(this);
            const orderId = select.data('id');
            const newStatus = select.val();
    
            $.ajax({
                url: "{{ route('orders.update.status', ['order' => 'ORDER_ID_PLACEHOLDER']) }}".replace('ORDER_ID_PLACEHOLDER', orderId),
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    status: newStatus
                },
                success: function () {
                    // تغيير اللون بناءً على الحالة
                    if (newStatus === 'تم الارسال') {
                        select.css('color', 'green');
                    } else {
                        select.css('color', 'orange');
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
    </script>
    
    @endsection
