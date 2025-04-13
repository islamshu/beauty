@extends('layouts.master')
@section('title', 'تفاصيل الاشتراك - ' . $subscription->id)

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">تفاصيل الاشتراك #{{ $subscription->id }}</h3>
                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="btn-group float-md-right">


                    </div>
                </div>
            </div>
            <div class="content-body">
                <section class="row">
                    <!-- معلومات الاشتراك الأساسية -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"><i class="la la-info-circle"></i> المعلومات الأساسية</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <table class="table table-striped">
                                                <tbody>
                                                    <tr>
                                                        <th width="30%">حالة الاشتراك:</th>
                                                        <td>
                                                            <span
                                                                    class="font-weight-bold 
                                                        {{ $subscription->status === 'active'
                                                            ? 'text-success'
                                                            : ($subscription->status === 'suspended'
                                                                ? 'text-warning'
                                                                : 'text-danger') }}">
                                                                    {{ __("subscription.status.{$subscription->status}") }}
                                                                </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>العميل:</th>
                                                        <td>
                                                            <a href="{{ route('clients.show', $subscription->client_id) }}">
                                                                {{ $subscription->client->name }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>الباقة:</th>
                                                        <td>
                                                            <a href="#" data-toggle="modal"
                                                                data-target="#packageDetails">
                                                                {{ $subscription->package->name }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>تاريخ البدء:</th>
                                                        <td>{{ $subscription->start_at }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>تاريخ الانتهاء:</th>
                                                        <td>
                                                            {{ $subscription->end_at ? $subscription->end_at : 'غير محدد' }}
                                                            @if (!$subscription->isActive())
                                                                <span class="badge badge-danger ml-1">منتهي</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>عدد الزيارات:</th>
                                                        <td>
                                                            <div class="progress progress-sm mt-1">
                                                                <div class="progress-bar bg-success"
                                                                    style="width: {{ ($subscription->total_visit / $subscription->package_visit) * 100 }}%">
                                                                </div>
                                                            </div>
                                                            {{ $subscription->total_visit }} من
                                                            {{ $subscription->package_visit }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>تم الإضافة بواسطة:</th>
                                                        <td>{{ $subscription->addedBy->name ?? 'غير معروف' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>تاريخ الإنشاء:</th>
                                                        <td>{{ $subscription->created_at->format('Y-m-d H:i') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>آخر تحديث:</th>
                                                        <td>{{ $subscription->updated_at->format('Y-m-d H:i') }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- المدفوعات والزيارات -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"><i class="la la-credit-card"></i> المدفوعات</h4>
                                <button class="btn btn-sm btn-primary add-payment-btn"
                                    data-subscription-id="{{ $subscription->id }}"
                                    data-total-amount="{{ $subscription->total_amount }}"
                                    data-paid-amount="{{ $subscription->paid_amount }}"
                                    data-remaining-amount="{{ $subscription->total_amount - $subscription->paid_amount }}">
                                    <i class="ft-plus"></i> {{ __('إضافة دفعة') }}
                                </button>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    @if ($subscription->payments->isEmpty())
                                        <div class="alert alert-info">لا توجد مدفوعات مسجلة</div>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>المبلغ</th>
                                                        <th>التاريخ</th>
                                                        <th>طريقة الدفع</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($subscription->payments as $payment)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ number_format($payment->amount, 2) }} شيكل</td>
                                                            <td>{{ $payment->payment_date }}</td>
                                                            <td>{{ $payment->payment_method }}</td>
                                                           
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card mt-1">

                            <div class="card-header">
                                <h4 class="card-title"><i class="la la-calendar-check-o"></i> سجل الزيارات</h4>

                                <button type="button" class="btn btn-sm btn-success add-visit-btn"
                                    data-subscription-id="{{ $subscription->id }}"
                                    data-package-id="{{ $subscription->package_id }}"
                                    data-package-name="{{ $subscription->package->name ?? '' }}"
                                    data-visits-count="{{ $subscription->total_visit }}"
                                    data-total-visits="{{ $subscription->package_visit }}">
                                    <i class="ft-plus"></i> {{ __('إضافة زيارة') }}
                                </button>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    @if ($subscription->visits->isEmpty())
                                        <div class="alert alert-info">لا توجد زيارات مسجلة</div>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>التاريخ</th>
                                                        <th>الوقت</th>
                                                        <th>ملاحظات</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($subscription->visits as $visit)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $visit->created_at }}</td>
                                                            <td>{{ $visit->created_at->format('H:i') }}</td>
                                                            <td>{{ Str::limit($visit->notes, 30) ?? '--' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- إدارة الحالة -->
                {{-- <section class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"><i class="la la-cogs"></i> إدارة حالة الاشتراك</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="btn-group" role="group">
                                    @foreach (['active', 'suspended', 'completed', 'canceled'] as $status)
                                        @if ($subscription->status != $status)
                                            <form action="{{ route('subscriptions.change-status', [$subscription->id, $status]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-{{ $subscription->statusColors[$status] }} mr-1">
                                                    {{ $subscription->statusTexts[$status] }}
                                                </button>
                                            </form>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> --}}
            </div>
        </div>
    </div>

    <!-- Modal تفاصيل الباقة -->
    <div class="modal fade" id="packageDetails" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">تفاصيل الباقة: {{ $subscription->package->name }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong><i class="la la-tag"></i> الاسم:</strong> {{ $subscription->package->name }}</p>
                            <p><strong><i class="la la-money"></i> السعر:</strong>
                                {{ number_format($subscription->package->price, 2) }} شيكل</p>
                            <p><strong><i class="la la-clock-o"></i> المدة:</strong> {{ $subscription->package->duration }}
                                يوم</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="la fa-tasks"></i> عدد الزيارات:</strong>
                                {{ $subscription->package->visit_count }}</p>
                            <p><strong><i class="la la-file-text"></i> الوصف:</strong></p>
                            <p>{{ $subscription->package->description }}</p>
                        </div>
                    </div>
                    <hr>
                    <h5><i class="la la-list"></i> الخدمات المتضمنة:</h5>
                    <ul>
                        @foreach ($subscription->package->services as $service)
                            <li>{{ $service->title }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal إضافة دفعة جديدة -->
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">إضافة دفعة جديدة</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="paymentForm" method="POST">
                    @csrf
                    <input type="hidden" name="subscription_id" value="">

                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('إضافة دفعة جديدة') }}</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('المبلغ') }} <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="amount" step="0.01" min="0.01"
                                required>
                        </div>

                        {{-- <div class="form-group">
                        <label>{{ __('طريقة الدفع') }} <span class="text-danger">*</span></label>
                        <select class="form-control" name="payment_method" required>
                            <option value="cash">{{ __('كاش') }}</option>
                            <option value="installment">{{ __('تقسيط') }}</option>
                        </select>
                    </div> --}}

                        <div class="form-group">
                            <label>{{ __('تاريخ الدفع') }} <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="payment_date" required>
                        </div>

                        <div class="form-group">
                            <label>{{ __('ملاحظات') }}</label>
                            <textarea class="form-control" name="notes" rows="2"></textarea>
                        </div>

                        <div class="payment-info alert alert-info p-2">
                            <div class="d-flex justify-content-between">
                                <span>{{ __('الإجمالي') }}:</span>
                                <span class="total-amount font-weight-bold"></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>{{ __('المدفوع') }}:</span>
                                <span class="paid-amount font-weight-bold"></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>{{ __('المتبقي') }}:</span>
                                <span class="remaining-amount font-weight-bold"></span>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ __('إلغاء') }}</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ __('حفظ') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addVisitModal" tabindex="-1" role="dialog" aria-labelledby="addVisitModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addVisitModalLabel">{{ __('إضافة زيارة جديدة') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addVisitForm" action="{{ route('visits.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="client_id" value="{{ $subscription->client_id }}">
                    <input type="hidden" id="modalSubscriptionId" name="subscription_id" value="">
                    <input type="hidden" id="modalPackageId" name="package_id" value="">

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="visit_date">{{ __('تاريخ الزيارة') }} <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" id="visit_date" name="visit_date"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="user_id">{{ __('المشرف') }} <span class="text-danger">*</span></label>
                            <select class="form-control" id="user_id" name="user_id" required>
                                <option value="">{{ __('اختر المشرف') }}</option>
                                @foreach (App\Models\User::get() as $supervisor)
                                    <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="notes">{{ __('ملاحظات') }}</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        </div>
                        <div class="alert alert-info">
                            <h6 class="font-weight-bold">{{ __('معلومات الاشتراك') }}</h6>
                            <p id="currentPackageName" class="mb-1"></p>
                            <p class="mb-0">{{ __('عدد الزيارات') }}: <span id="currentVisitsCount"
                                    class="font-weight-bold"></span>/<span id="totalVisitsCount"
                                    class="font-weight-bold"></span></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ __('إلغاء') }}</button>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="ft-save"></i> {{ __('حفظ') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .progress {
            height: 10px;
            border-radius: 5px;
        }

        .badge {
            font-size: 90%;
            padding: 0.35em 0.65em;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table th {
            white-space: nowrap;
        }
    </style>
@endpush
@section('script')
    <script>
        $(function() {
            $('.add-payment-btn').click(function() {
                const subscriptionId = $(this).data('subscription-id');
                const totalAmount = $(this).data('total-amount');
                const paidAmount = $(this).data('paid-amount');
                const remainingAmount = $(this).data('remaining-amount');

                $('#paymentModal input[name="subscription_id"]').val(subscriptionId);
                $('#paymentModal .total-amount').text(totalAmount + ' ₪');
                $('#paymentModal .paid-amount').text(paidAmount + ' ₪');
                $('#paymentModal .remaining-amount').text(remainingAmount + ' ₪');
                $('#paymentModal input[name="payment_date"]').val(new Date().toISOString().split('T')[0]);

                $('#paymentModal').modal('show');
            });
        });
        $(document).on('click', '.add-visit-btn', function() {
            var btn = $(this);
            $('#modalSubscriptionId').val(btn.data('subscription-id'));
            $('#modalPackageId').val(btn.data('package-id'));

            // Update modal info
            $('#currentPackageName').text(btn.data('package-name'));
            $('#currentVisitsCount').text(btn.data('visits-count'));
            $('#totalVisitsCount').text(btn.data('total-visits'));

            // Set default visit date to now
            var now = new Date();
            var formatted = now.toISOString().slice(0, 16);
            $('#visit_date').val(formatted);

            $('#addVisitModal').modal('show');
        });
        $('#addVisitForm').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            var submitBtn = form.find('#submitBtn');
            submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> {{ __('جاري الحفظ') }}');

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    $('#addVisitModal').modal('hide');
                    toastr.success(response.message || '{{ __('تمت إضافة الزيارة بنجاح') }}');

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
        $('#paymentForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route('subscription-payments.store') }}',
                type: 'POST',
                data: $(this).serialize(),
                success: function() {
                    location.reload();
                },
                error: function(xhr) {
                    alert(xhr.responseJSON.message || '{{ __('حدث خطأ أثناء الحفظ') }}');
                }
            });
        });
    </script>

@endsection
