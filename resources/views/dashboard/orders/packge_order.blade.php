@extends('layouts.master')
@section('title', 'تفاصيل الطلب')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('تفاصيل الطلب') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('تفاصيل الطلب #') }}{{ $order->id }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <section id="order-details">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <i class="ft-info"></i> {{ __('معلومات الطلب الأساسية') }}
                                    </h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form form-horizontal">
                                            <div class="form-body">
                                                <!-- الصف الأول -->
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="label-control">{{ __('رقم الطلب') }}</label>
                                                            <div class="form-control-static">
                                                                {{ $order->id }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="label-control">{{ __('تاريخ الطلب') }}</label>
                                                            <div class="form-control-static">
                                                                {{ $order->created_at->format('Y-m-d H:i') }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="label-control">{{ __('حالة العميل') }}</label>
                                                            <div class="form-control-static">
                                                                @if ($order->client)
                                                                    <a href="{{ route('clients.show', $order->client->id) }}"
                                                                        class="d-flex align-items-center">
                                                                        {{ $order->client->name }}
                                                                        @if ($order->client->activeSubscription)
                                                                            <span
                                                                                class="badge badge-success ml-1">نشط</span>
                                                                        @else
                                                                            <span class="badge badge-warning ml-1">غير
                                                                                نشط</span>
                                                                        @endif
                                                                    </a>
                                                                @else
                                                                <button type="button"
                                                                class="btn btn-sm btn-primary show-add-client-modal"
                                                                data-order-id="{{ $order->id }}">
                                                                <i class="ft-plus"></i> إضافة عميل
                                                            </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="label-control">{{ __('رقم الهاتف') }}</label>
                                                            <div class="form-control-static" style="direction: ltr">
                                                                <a href="tel:{{ $order->phone }}" ><span style="direction: ltr">{{ $order->phone }}</span></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- الصف الثاني -->
                                                <div class="row mt-1">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="label-control">{{ __('اسم العميل') }}</label>
                                                            <div class="form-control-static font-weight-bold">
                                                                {{ $order->full_name }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if ($order->email)
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label
                                                                    class="label-control">{{ __('البريد الإلكتروني') }}</label>
                                                                <div class="form-control-static">
                                                                    <a
                                                                        href="mailto:{{ $order->email }}">{{ $order->email }}</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('dashboard.orders.modals.add_client')
                    <!-- معلومات الباقة -->
                    <div class="row mt-1">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <i class="ft-box"></i> {{ __('معلومات الباقة') }}
                                    </h4>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="30%">{{ __('اسم الباقة') }}</th>
                                                        <th width="20%">{{ __('السعر') }}</th>
                                                        <th width="25%">{{ __('عدد الزيارات') }}</th>
                                                        <th>مدة الباقة</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $order->package->name }}</td>
                                                        <td>{{ number_format($order->package->price, 2) }}
                                                            {{ __('شيكل') }}</td>
                                                        <td>{{ $order->package->number_of_visits }}</td>
                                                        <td>{{ format_package_duration($order->package->id) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- معلومات إضافية -->
                    <div class="row mt-1">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <i class="ft-map-pin"></i> {{ __('معلومات العنوان') }}
                                    </h4>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="label-control">{{ __('العنوان التفصيلي') }}</label>
                                                    <div class="form-control-static" style="white-space: pre-line;">
                                                        {{ $order->address }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="label-control">{{ __('الموقع على الخريطة') }}</label>
                                                    @if ($order->latitude && $order->longitude)
                                                        <div id="order-map"
                                                            style="height: 200px; border: 1px solid #ddd;"></div>
                                                    @else
                                                        <div class="alert alert-warning">
                                                            {{ __('لا يوجد إحداثيات للعنوان') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- أزرار التحكم -->
                    <div class="row mt-2">
                        <div class="col-12 text-center">

                            <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                                <i class="ft-arrow-right"></i> {{ __('عودة للقائمة') }}
                            </a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    const fetchOrderUrl = "{{ route('orders.fetch', ':id') }}";

    $(document).on('click', '.show-add-client-modal', function() {
        let orderId = $(this).data('order-id');
        let url = fetchOrderUrl.replace(':id', orderId);

        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                // ضع القيم في الحقول داخل المودال
                $('#displayOrderName').val(response.full_name);
                $('#clientName').val(response.full_name);
                $('#displayOrderPhone').val(response.country_code + response.phone_number);
                $('#displayOrderPackage').val(response.package_name);
                $('#displayOrderPrice').val(response.price);
                $('#clientAddress').val(response.address);


                // تعبئة الحقول الخاصة بالاشتراك
                $('#packgevisit').val(response.number_of_visits);
                $('#total_amount').val(response.price);

                // تعبئة الحقول الخفية
                $('#orderIdInput').val(response.id);
                $('#packageIdInput').val(response.package_id);

                // تعبئة رقم الهاتف في الحقول المخصصة له
                $('#phoneNumber').val(response.phone_number);
                $('#countryCode').val(response.country_code);

                // فتح المودال
                $('#addClientModal').modal('show');
            },
            error: function() {
                alert('حدث خطأ أثناء جلب البيانات');
            }
        });
    });
</script>
    <script>
        // استدعاء عند تغيير تاريخ البدء أو تغيير الباقة
        $('#startDate, #packageIdInput').on('change', calculateEndDate);

        // حساب المبلغ المتبقي تلقائياً
        $('input[name="total_amount"], input[name="paid_amount"]').on('input', function() {
            var total = parseFloat($('input[name="total_amount"]').val()) || 0;
            var paid = parseFloat($('input[name="paid_amount"]').val()) || 0;
            // يمكنك عرض المبلغ المتبقي إذا أردت
        });

        function calculateEndDate() {
            const packageId = $('#packageIdInput').val();
            const startDate = $('#startDate').val();

            if (!packageId || !startDate) {
                $('#endDate').val('يجب تحديد تاريخ البدء');
                return;
            }
            let url = "{{ route('packages.calculate-end-date', ['package' => ':packageId']) }}".replace(':packageId',
                packageId);
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    start_date: startDate
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                },
                beforeSend: function() {
                    $('#endDate').val('جاري الحساب...');
                },
                success: function(response) {
                    if (response.success) {
                        $('#endDate').val(response.end_date);
                        $('#durationInfo').text(`مدة الاشتراك: ${response.duration}`);
                    } else {
                        $('#endDate').val('حدث خطأ');
                        toastr.error(response.message || 'خطأ في الحساب');
                    }
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.message || 'فشل الاتصال بالخادم';
                    $('#endDate').val('!خطأ');
                    toastr.error(message);
                }
            });
        }
        $(document).ready(function() {
            if ($('#addSubscription').is(':checked')) {
                $('#paid_amount').attr('required', 'required');
            } else {
                $('#paid_amount').removeAttr('required');
            }
            // When add client button is clicked
          

            // Toggle subscription fields
            $('#addSubscription').change(function() {
                $('#subscriptionFields').toggle(this.checked);
                if (this.checked) {
                    $('#paid_amount').attr('required', 'required');
                } else {
                    $('#paid_amount').removeAttr('required');
                }
            });

            // Handle form submission
            $('#addClientForm').on('submit', function(e) {
                e.preventDefault();

                var form = $(this);
                var submitBtn = form.find('#saveClientBtn');
                submitBtn.prop('disabled', true).html(
                    '<i class="fa fa-spinner fa-spin"></i> {{ __('جاري الحفظ') }}');

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#addClientModal').modal('hide');
                        toastr.success(response.message ||
                            '{{ __('تمت إضافة العميل بنجاح') }}');

                        // Reload the page to show updated data
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).html(
                            '<i class="ft-save"></i> {{ __('حفظ') }}');

                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = '';

                            $.each(errors, function(key, value) {
                                errorMessage += value + '<br>';
                            });

                            toastr.error(errorMessage);
                        } else {
                            toastr.error(xhr.responseJSON.message ||
                                '{{ __('حدث خطأ أثناء حفظ البيانات') }}');
                        }
                    }
                });
            });
        });
    </script>
@endsection

@section('styles')
    <style>
        .label-control {
            font-weight: 600;
            color: #5A5A5A;
        }

        .form-control-static {
            padding: 8px 0;
            border-bottom: 1px solid #EEE;
            min-height: 35px;
        }

        .card-header h4 {
            display: flex;
            align-items: center;
        }

        .card-header h4 i {
            margin-left: 10px;
        }

        #order-details .card {
            box-shadow: 0 2px 8px 0 rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection
