@extends('layouts.master')
@section('title', 'بيانات العميل')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('بيانات العميل') }}</h3>
                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="btn-group float-md-right">
                        <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-info">
                            <i class="ft-edit"></i> {{ __('تعديل') }}
                        </a>
                        <a href="{{ route('clients.index') }}" class="btn btn-primary">
                            <i class="ft-arrow-right"></i> {{ __('رجوع للقائمة') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Client Information Section -->
                <section>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('المعلومات الأساسية') }}</h4>
                        </div>
                        @include('dashboard.inc.alerts')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="30%">{{ __('الاسم') }}</th>
                                            <td>{{ $client->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('رقم الهاتف') }}</th>
                                            <td>{{ $client->phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('العنوان') }}</th>
                                            <td>{{ $client->address }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('حالة العميل') }}</th>
                                            <td>
                                                @if ($client->activeSubscription)
                                                    <div class="shadow-sm border rounded px-2 py-2 text-center"
                                                        style="background: #67656d;">
                                                        <div class="text-muted small mb-1">
                                                            حالة الاشتراك:
                                                            <span
                                                                class="font-weight-bold 
                                                        {{ $client->activeSubscription->status === 'active'
                                                            ? 'text-success'
                                                            : ($client->activeSubscription->status === 'suspended'
                                                                ? 'text-warning'
                                                                : 'text-danger') }}">
                                                                {{ __("subscription.status.{$client->activeSubscription->status}") }}
                                                            </span>
                                                        </div>

                                                        <div class="btn-group btn-group-sm" role="group"
                                                            aria-label="Subscription Controls">
                                                            @if ($client->activeSubscription->status !== 'active')
                                                                <form
                                                                    action="{{ route('subscriptions.activate', $client->activeSubscription) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-outline-success"
                                                                        title="تفعيل">
                                                                        <i class="ft-check"></i>
                                                                    </button>
                                                                </form>
                                                            @endif



                                                            @if ($client->activeSubscription->status !== 'canceled')
                                                                <form
                                                                    action="{{ route('subscriptions.cancel', $client->activeSubscription) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('هل أنت متأكد من إلغاء الاشتراك؟')">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-outline-danger"
                                                                        title="إلغاء">
                                                                        إلغاء الاشتراك
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="text-center">
                                                        <span class="badge badge-warning mb-2 d-block">لا يوجد اشتراك</span>
                                                        <button type="button" class="btn btn-sm btn-primary"
                                                            data-toggle="modal" data-target="#addClientModal"
                                                            data-client-id="{{ $client->id }}">
                                                            <i class="ft-plus"></i> إضافة باقة
                                                        </button>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6 text-center">
                                    @if ($client->qr_code)
                                        <img src="{{ asset($client->qr_code) }}" width="150" height="150"
                                            alt="QR Code">
                                        <p class="mt-1">{{ __('رمز العضوية') }} {{ $client->id_number }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Client Subscriptions Section with Accordion -->
                <section class="mt-2">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('الاشتراكات والزيارات') }}</h4>
                        </div>
                        <div class="card-body">
                            @if ($client->subscriptions->count() > 0)
                                <div class="accordion" id="subscriptionsAccordion">
                                    @foreach ($client->subscriptions->sortByDesc('created_at') as $subscription)
                                        <div class="card mb-1 border-0 shadow-sm">
                                            <div class="card-header bg-light" id="heading{{ $subscription->id }}">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link text-dark font-weight-bold"
                                                            type="button" data-toggle="collapse"
                                                            data-target="#collapse{{ $subscription->id }}"
                                                            aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                                            aria-controls="collapse{{ $subscription->id }}">
                                                            <i
                                                                class="ft-chevron-{{ $loop->first ? 'down' : 'right' }}"></i>
                                                            {{ $subscription->package->name ?? __('غير محدد') }}
                                                            <span
                                                                class="badge badge-{{ $subscription->isActive() ? 'success' : 'danger' }} ml-2">
                                                                {{ $subscription->total_visit }}/{{ $subscription->package_visit }}
                                                            </span>
                                                        </button>
                                                    </h5>
                                                    <div>
                                                        <span class="text-muted mr-2">
                                                            {{ $subscription->start_at }} -
                                                            {{ $subscription->end_at ?? __('غير محدد') }}
                                                        </span>
                                                        @if ($subscription->isActive())
                                                            <button type="button"
                                                                class="btn btn-sm btn-success add-visit-btn"
                                                                data-subscription-id="{{ $subscription->id }}"
                                                                data-package-id="{{ $subscription->package_id }}"
                                                                data-package-name="{{ $subscription->package->name ?? '' }}"
                                                                data-visits-count="{{ $subscription->total_visit }}"
                                                                data-total-visits="{{ $subscription->package_visit }}">
                                                                <i class="ft-plus"></i> {{ __('إضافة زيارة') }}
                                                            </button>
                                                            <button class="btn btn-sm btn-primary add-payment-btn"
                                                                data-subscription-id="{{ $subscription->id }}"
                                                                data-total-amount="{{ $subscription->total_amount }}"
                                                                data-paid-amount="{{ $subscription->paid_amount }}"
                                                                data-remaining-amount="{{ $subscription->total_amount - $subscription->paid_amount }}">
                                                                <i class="ft-plus"></i> {{ __('إضافة دفعة') }}
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="collapse{{ $subscription->id }}"
                                                class="collapse {{ $loop->first ? 'show' : '' }}"
                                                aria-labelledby="heading{{ $subscription->id }}"
                                                data-parent="#subscriptionsAccordion">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between mb-3">
                                                        <div>
                                                            <span
                                                                class="badge badge-{{ $subscription->isActive() ? 'success' : 'danger' }}">
                                                                {{ $subscription->isActive() ? __('نشط') : __('منتهي') }}
                                                            </span>
                                                        </div>
                                                        <div class="text-muted">
                                                            {{ __('تاريخ الإنشاء') }}: {{ $subscription->created_at }}
                                                        </div>
                                                    </div>

                                                    <!-- New Layout for Visits and Payments Side by Side -->
                                                    <div class="row mt-4">
                                                        <!-- Visits Section -->
                                                        <div class="col-md-6" style="border: 5px solid #ddd;">
                                                            <h5 class="mb-3 border-bottom pt-2 pb-2"
                                                                style="font-size: 1.5rem; font-weight: 700; font-family: 'Tahoma', sans-serif;">
                                                                سجل الزيارات
                                                            </h5>
                                                            <div class="d-flex justify-content-between mb-3">
                                                                <div>
                                                                    <span
                                                                        class="font-weight-bold">{{ __('إجمالي عدد الزيارات المقررة') }}:
                                                                        {{ $subscription->package_visit }} </span>
                                                                    <span class="mx-2">|</span>
                                                                    <span
                                                                        class="font-weight-bold text-success">{{ __('اجمالي الزيارات') }}:
                                                                        {{ $subscription->total_visit }}</span>
                                                                    <span class="mx-2">|</span>
                                                                    <span
                                                                        class="font-weight-bold text-danger">{{ __('المتبقي') }}:
                                                                        {{ $subscription->total_visit }}/{{ $subscription->package_visit }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            @if ($subscription->visits->count() > 0)
                                                                <div class="table-responsive">
                                                                    <table class="table table-striped table-hover">
                                                                        <thead class="bg-light">
                                                                            <tr>
                                                                                <th width="5%">#</th>
                                                                                <th width="45%">
                                                                                    {{ __('تاريخ الزيارة') }}</th>
                                                                                <th width="20%">{{ __('المشرف') }}
                                                                                </th>
                                                                                <th width="20%">{{ __('ملاحظات') }}
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($subscription->visits->sortByDesc('visit_date') as $visit)
                                                                                <tr>
                                                                                    <td>{{ $loop->iteration }}</td>
                                                                                    <td>{{ $visit->visit_date }}</td>
                                                                                    <td>{{ $visit->supervisor->name }}</td>
                                                                                    <td>{{ $visit->notes ?? __('لا يوجد') }}
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            @else
                                                                <div class="alert alert-info">
                                                                    {{ __('لا يوجد زيارات مسجلة لهذا الاشتراك') }}
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <!-- Payments Section -->
                                                        <div class="col-md-6" style="border: 5px solid #ddd;">
                                                            <h5 class="mb-3 border-bottom pt-2 pb-2"
                                                                style="font-size: 1.5rem; font-weight: 700; font-family: 'Tahoma', sans-serif;">
                                                                سجل الدفعات
                                                            </h5>
                                                            <div class="d-flex justify-content-between mb-3">
                                                                <div>
                                                                    <span
                                                                        class="font-weight-bold">{{ __('إجمالي المبلغ') }}:
                                                                        {{ $subscription->total_amount }} ₪</span>
                                                                    <span class="mx-2">|</span>
                                                                    <span
                                                                        class="font-weight-bold text-success">{{ __('المدفوع') }}:
                                                                        {{ $subscription->paid_amount }} ₪</span>
                                                                    <span class="mx-2">|</span>
                                                                    <span
                                                                        class="font-weight-bold text-danger">{{ __('المتبقي') }}:
                                                                        {{ $subscription->total_amount - $subscription->paid_amount }}
                                                                        ₪</span>
                                                                </div>
                                                            </div>

                                                            @if ($subscription->payments->count() > 0)
                                                                <div class="table-responsive">
                                                                    <table class="table table-striped table-hover">
                                                                        <thead class="bg-light">
                                                                            <tr>
                                                                                <th width="10%">#</th>
                                                                                <th width="15%">{{ __('المبلغ') }}
                                                                                </th>
                                                                                <th width="20%">{{ __('تاريخ الدفع') }}
                                                                                </th>
                                                                                <th width="15%">{{ __('المستلم') }}
                                                                                </th>
                                                                                <th width="15%">{{ __('ملاحظات') }}
                                                                                </th>
                                                                                <th width="10%">{{ __('إجراءات') }}
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($subscription->payments->sortByDesc('payment_date') as $payment)
                                                                                <tr>
                                                                                    <td>{{ $loop->iteration }}</td>
                                                                                    <td>{{ $payment->amount }} ₪</td>
                                                                                    <td>{{ $payment->payment_date }}</td>
                                                                                    <td>{{ $payment->receiver->name }}</td>
                                                                                    <td>{{ $payment->notes ?? '--' }}</td>
                                                                                    <td>
                                                                                        <button
                                                                                            class="btn btn-sm btn-danger delete-payment-btn"
                                                                                            data-payment-id="{{ $payment->id }}"
                                                                                            data-amount="{{ $payment->amount }}">
                                                                                            <i class="ft-trash"></i>
                                                                                        </button>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            @else
                                                                <div class="alert alert-info">
                                                                    {{ __('لا يوجد دفعات مسجلة لهذا الاشتراك') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">
                                    {{ __('لا يوجد اشتراكات مسجلة لهذا العميل') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog" aria-labelledby="addPaymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPaymentModalLabel">{{ __('إضافة دفعة جديدة') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addPaymentForm" action="{{ route('subscription-payments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="subscription_id" id="paymentSubscriptionId" value="">

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="payment_amount">{{ __('المبلغ') }} <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="payment_amount" name="amount"
                                step="0.01" min="0.01" required>
                        </div>

                        <div class="form-group">
                            <label for="payment_method">{{ __('طريقة الدفع') }} <span
                                    class="text-danger">*</span></label>
                            <select class="form-control" id="payment_method" name="payment_method" required>
                                <option value="cash">كاش</option>
                                <option value="installment">تقسيط</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="payment_date">{{ __('تاريخ الدفع') }} <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="payment_date" name="payment_date" required>
                        </div>

                        <div class="form-group">
                            <label for="payment_notes">{{ __('ملاحظات') }}</label>
                            <textarea class="form-control" id="payment_notes" name="notes" rows="2"></textarea>
                        </div>

                        <div class="alert alert-info">
                            <h6 class="font-weight-bold">{{ __('معلومات الاشتراك') }}</h6>
                            <p class="mb-1">{{ __('إجمالي المبلغ') }}: <span id="paymentTotalAmount"
                                    class="font-weight-bold"></span> ₪</p>
                            <p class="mb-1">{{ __('المدفوع') }}: <span id="paymentPaidAmount"
                                    class="font-weight-bold"></span> ₪</p>
                            <p class="mb-0">{{ __('المتبقي') }}: <span id="paymentRemainingAmount"
                                    class="font-weight-bold"></span> ₪</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ __('إلغاء') }}</button>
                        <button type="submit" class="btn btn-primary" id="submitPaymentBtn">
                            <i class="ft-save"></i> {{ __('حفظ الدفعة') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal حذف دفعة -->
    <div class="modal fade" id="deletePaymentModal" tabindex="-1" role="dialog"
        aria-labelledby="deletePaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePaymentModalLabel">{{ __('تأكيد الحذف') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deletePaymentForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>{{ __('هل أنت متأكد من حذف هذه الدفعة بقيمة') }} <span id="deletePaymentAmount"
                                class="font-weight-bold"></span> ₪؟</p>
                        <p class="text-danger">{{ __('لا يمكن التراجع عن هذا الإجراء') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ __('إلغاء') }}</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="ft-trash"></i> {{ __('حذف') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="paymentModal">
        <div class="modal-dialog">
            <div class="modal-content">
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

    <!-- Add Visit Modal -->
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
                    <input type="hidden" name="client_id" value="{{ $client->id }}">
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
</div>@endsection

@section('script')
    <!-- Toastr Notifications -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            // فتح مودال إضافة دفعة
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

            // حذف دفعة
            $('.delete-payment').click(function() {
                const paymentId = $(this).data('payment-id');

                if (confirm('{{ __('هل أنت متأكد من حذف هذه الدفعة؟') }}')) {
                    $.ajax({
                        url: '/subscription-payments/' + paymentId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            location.reload();
                        }
                    });
                }
            });

            // إرسال نموذج الدفعة
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
        });
    </script>
    <script>
        $(document).ready(function() {

            $('.delete-payment-btn').on('click', function(e) {
                e.preventDefault();

                const paymentId = $(this).data('payment-id');
                const amount = $(this).data('amount');
                alert(paymentId);
                Swal.fire({
                    title: 'هل أنت متأكد؟',
                    text: `هل تريد حذف الدفعة بقيمة ${amount} ₪؟`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'نعم، احذف!',
                    cancelButtonText: 'إلغاء'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // إرسال طلب AJAX لحذف الدفعة
                        $.ajax({
                            url: "{{ route('subscription-payments.destroy', ['id' => '']) }}" + paymentId,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}' // مهم لحماية الطلب
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'تم الحذف!',
                                        response.message,
                                        'success'
                                    ).then(() => {
                                        // إعادة تحميل الصفحة بعد الحذف
                                        location.reload();
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire(
                                    'خطأ!',
                                    'حدث خطأ أثناء محاولة الحذف',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
            // Toastr configuration
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-left",
                "rtl": true,
                "timeOut": "5000"
            };

            // When add visit button is clicked
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

            // Handle form submission
            $('#addVisitForm').on('submit', function(e) {
                e.preventDefault();

                var form = $(this);
                var submitBtn = form.find('#submitBtn');
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
                        $('#addVisitModal').modal('hide');
                        toastr.success(response.message ||
                            '{{ __('تمت إضافة الزيارة بنجاح') }}');

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

            // Accordion arrow toggle
            $('.accordion .card-header button').on('click', function() {
                $(this).find('i').toggleClass('ft-chevron-right ft-chevron-down');
            });
        });
    </script>
@endsection
