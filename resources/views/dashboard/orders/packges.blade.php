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
                                                <td>{{ $order->phone }}</td>
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
                                                        <button type="button" class="btn btn-sm btn-primary"
                                                            data-toggle="modal" data-target="#addClientModal"
                                                            data-order-id="{{ $order->id }}"
                                                            data-order-phone="{{ $order->phone }}"
                                                            data-order-name="{{ $order->full_name }}"

                                                            data-order-package="{{ @$order->package->name ?? 'تم حذف الباقة' }}"
                                                            data-order-price="{{ @$order->package->price ?? 0  }}"
                                                            data-order-visit="{{ @$order->package->number_of_visits ?? 0  }}"

                                                            data-order-price="{{ @$order->package->price ?? 'تم حذف الباقة' }}">
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
    <div class="modal fade" id="addClientModal" tabindex="-1" role="dialog" aria-labelledby="addClientModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addClientModalLabel">{{ __('إضافة عميل جديد من الطلب') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addClientForm" action="{{ route('clients.storeFromOrder') }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" id="orderIdInput">
                    <input type="hidden" name="package_id" id="packageIdInput" value="{{ @$order->package->id }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">{{ __('بيانات الطلب') }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>{{ __('اسم العميل') }}</label>
                                            <input type="text" class="form-control" id="displayOrderName" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('رقم الهاتف') }}</label>
                                            <input type="text" class="form-control" id="displayOrderPhone" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('الباقة المطلوبة') }}</label>
                                            <input type="text" class="form-control" id="displayOrderPackage" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('سعر الباقة') }}</label>
                                            <input type="text" class="form-control" id="displayOrderPrice" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">{{ __('بيانات العميل الجديد') }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="clientName">{{ __('اسم العميل') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="clientName" name="name"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label for="clientPhone">{{ __('رقم الهاتف') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="clientPhone" name="phone"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label for="clientAddress">{{ __('العنوان') }}</label>
                                            <input type="text" class="form-control" id="clientAddress"
                                                name="address">
                                        </div>

                                        <!-- إضافة خيارات الاشتراك -->
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="addSubscription"
                                                    name="add_subscription" value="1" checked>
                                                <label class="custom-control-label"
                                                    for="addSubscription">{{ __('إضافة اشتراك بالباقة المطلوبة') }}</label>
                                            </div>
                                        </div>

                                        <div id="subscriptionFields">
                                            <div class="form-group">
                                                <label for="start_date">{{ __('تاريخ البدء') }}</label>
                                                <input type="date" class="form-control" name="start_date"
                                                    id="startDate">
                                            </div>
                                            <div class="form-group">
                                                <label>{{ __('تاريخ الانتهاء') }}</label>
                                                <input type="text" class="form-control" id="endDate" readonly>
                                                <small id="durationInfo" class="form-text text-muted"></small>
                                            </div>
                                            <div class="form-group">
                                                <label for="payment_method">{{ __('طريقة الدفع') }}</label>
                                                <select class="form-control" name="payment_method" required>
                                                    <option value="full">نقدي</option>
                                                    <option value="installments">تقسيط</option>
                                                </select>
                                            </div>
                                           
                                            <div class="form-group">
                                                <label for="total_amount">{{ __('المبلغ الإجمالي') }}</label>
                                                <input type="number" id="total_amount" step="0.01" class="form-control"
                                                    name="total_amount" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="packgevisit">{{ __('عدد الزيارات للباقة') }}</label>
                                                <input type="number" id="packgevisit" step="1" class="form-control"
                                                    name="package_visit" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="paid_amount">{{ __('المبلغ المدفوع') }}</label>
                                                <input type="number" step="0.01" class="form-control"
                                                    name="paid_amount" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ __('إلغاء') }}</button>
                        <button type="submit" class="btn btn-primary" id="saveClientBtn">
                            <i class="ft-save"></i> {{ __('حفظ العميل والاشتراك') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
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
            $('#addClientModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var modal = $(this);

                // Set order data in the form
                modal.find('#orderIdInput').val(button.data('order-id'));
                modal.find('#displayOrderName').val(button.data('order-name'));
                modal.find('#displayOrderPhone').val(button.data('order-phone'));
                modal.find('#displayOrderPackage').val(button.data('order-package'));
                modal.find('#displayOrderPrice').val(button.data('order-price') + ' شيكل');

                // Pre-fill client data from order
                modal.find('#clientName').val(button.data('order-name'));
                modal.find('#clientPhone').val(button.data('order-phone'));
                modal.find('#total_amount').val(button.data('order-price'));
                modal.find('#packgevisit').val(button.data('order-visit'));

                
            });

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
