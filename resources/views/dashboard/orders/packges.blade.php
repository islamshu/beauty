@extends('layouts.master')
@section('title', 'طلبات الباقات')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('طلبات الباقات') }}</h3>
                </div>
            </div>
            <div class="content-body">
                <section>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('قائمة طلبات الباقات') }}</h4>
                        </div>
                        <div class="card-body">
                            @include('dashboard.inc.alerts')

                            <div class="table-responsive">
                                <table class="table table-striped" id="storestable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('اسم المستخدم') }}</th>
                                            <th>{{ __('رقم الهاتف') }}</th>
                                            <th>{{ __('الباقة') }}</th>
                                            <th>{{ __('سعر الباقة') }}</th>
                                            <th>{{ __('الحالة') }}</th>
                                            <th>{{ __('العميل') }}</th>
                                            <th>{{ __('الاجراءات') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $key => $order)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $order->full_name }}</td>
                                                <td style="direction: ltr">{{ $order->phone }}</td>
                                                <td>{{ @$order->package->name ?? 'تم حذف الباقة' }}</td>
                                                <td>{{ @$order->package->price ?? 'تم حذف الباقة' }} شيكل</td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $order->status == '1' ? 'success' : 'danger' }}">
                                                        {{ $order->status == '1' ? 'تمت المشاهدة' : 'غير مشاهد' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($order->client)
                                                        <a href="{{ route('clients.show', $order->client->id) }}"
                                                            class="d-flex align-items-center">
                                                            {{ $order->client->name }}
                                                            @if ($order->client->activeSubscription)
                                                                <span class="badge badge-success ml-1">نشط</span>
                                                            @else
                                                                <span class="badge badge-warning ml-1">غير نشط</span>
                                                            @endif
                                                        </a>
                                                    @else
                                                        <button type="button"
                                                            class="btn btn-sm btn-primary show-add-client-modal"
                                                            data-order-id="{{ $order->id }}">
                                                            <i class="ft-plus"></i> إضافة عميل
                                                        </button>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('pacgkeorders.show', $order->id) }}"
                                                            class="btn btn-info btn-sm" title="{{ __('عرض') }}">
                                                            <i class="ft-eye"></i>
                                                        </a>
                                                        @if (isAdmin())
                                                            <form action="{{ route('pacgkeorders.delete', $order->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('{{ __('هل أنت متأكد من الحذف؟') }}')"
                                                                    title="{{ __('حذف') }}">
                                                                    <i class="ft-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Add Client Modal -->
    @include('dashboard.orders.modals.add_client')
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

            // When add client button is clicked
            // $('#addClientModal').on('show.bs.modal', function(event) {
            //     var button = $(event.relatedTarget);
            //     var modal = $(this);

            //     // Set order data in the form
            //     modal.find('#orderIdInput').val(button.data('order-id'));
            //     modal.find('#displayOrderName').val(button.data('order-name'));
            //     modal.find('#displayOrderPhone').val(button.data('order-phone'));
            //     modal.find('#displayOrderPackage').val(button.data('order-package'));
            //     modal.find('#displayOrderPrice').val(button.data('order-price') + ' شيكل');

            //     // Pre-fill client data from order
            //     modal.find('#clientName').val(button.data('order-name'));
            //     modal.find('#clientPhone').val(button.data('order-phone'));
            //     modal.find('#total_amount').val(button.data('order-price'));
            //     modal.find('#packgevisit').val(button.data('order-visit'));


            // });

            // Toggle subscription fields
            $('#addSubscription').change(function() {
                $('#subscriptionFields').toggle(this.checked);
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
