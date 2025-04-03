@extends('layouts.master')
@section('title','بيانات العميل')

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
                                </table>
                            </div>
                            <div class="col-md-6 text-center">
                                @if($client->qr_code)
                                    <img src="{{ asset($client->qr_code) }}" width="150" height="150" alt="QR Code">
                                    <p class="mt-1">{{ __('رمز العميل') }}</p>
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
                                                <button class="btn btn-link text-dark font-weight-bold" type="button" 
                                                    data-toggle="collapse" 
                                                    data-target="#collapse{{ $subscription->id }}" 
                                                    aria-expanded="{{ $loop->first ? 'true' : 'false' }}" 
                                                    aria-controls="collapse{{ $subscription->id }}">
                                                    <i class="ft-chevron-{{ $loop->first ? 'down' : 'right' }}"></i>
                                                    {{ $subscription->package->name ?? __('غير محدد') }} 
                                                    <span class="badge badge-{{ $subscription->isActive() ? 'success' : 'danger' }} ml-2">
                                                        {{ $subscription->total_visit }}/{{ $subscription->package_visit }}
                                                    </span>
                                                </button>
                                            </h5>
                                            <div>
                                                <span class="text-muted mr-2">
                                                    {{ $subscription->start_at }} - 
                                                    {{ $subscription->end_at ?? __('غير محدد') }}
                                                </span>
                                                @if($subscription->isActive())
                                                    <button type="button" class="btn btn-sm btn-success add-visit-btn" 
                                                        data-subscription-id="{{ $subscription->id }}"
                                                        data-package-id="{{ $subscription->package_id }}"
                                                        data-package-name="{{ $subscription->package->name ?? '' }}"
                                                        data-visits-count="{{ $subscription->total_visit }}"
                                                        data-total-visits="{{ $subscription->package_visit }}">
                                                        <i class="ft-plus"></i> {{ __('إضافة زيارة') }}
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div id="collapse{{ $subscription->id }}" class="collapse {{ $loop->first ? 'show' : '' }}" 
                                        aria-labelledby="heading{{ $subscription->id }}" data-parent="#subscriptionsAccordion">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-3">
                                                <div>
                                                    <span class="badge badge-{{ $subscription->isActive() ? 'success' : 'danger' }}">
                                                        {{ $subscription->isActive() ? __('نشط') : __('منتهي') }}
                                                    </span>
                                                </div>
                                                <div class="text-muted">
                                                    {{ __('تاريخ الإنشاء') }}: {{ $subscription->created_at }}
                                                </div>
                                            </div>

                                            <h5 class="mb-3 border-bottom pb-2">{{ __('سجل الزيارات') }}</h5>
                                            @if($subscription->visits->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover">
                                                        <thead class="bg-light">
                                                            <tr>
                                                                <th width="5%">#</th>
                                                                <th width="20%">{{ __('تاريخ الزيارة') }}</th>
                                                                <th width="20%">{{ __('المشرف') }}</th>
                                                                <th width="45%">{{ __('ملاحظات') }}</th>
                                                                <th width="10%">{{ __('الإجراءات') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($subscription->visits->sortByDesc('visit_date') as $visit)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $visit->visit_date }}</td>
                                                                    <td>{{ $visit->supervisor->name }}</td>
                                                                    <td>{{ $visit->notes ?? __('لا يوجد') }}</td>
                                                                    <td>
                                                                        <a href="" 
                                                                            class="btn btn-sm btn-warning" 
                                                                            title="{{ __('تعديل') }}">
                                                                            <i class="ft-edit"></i>
                                                                        </a>
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

<!-- Add Visit Modal -->
<div class="modal fade" id="addVisitModal" tabindex="-1" role="dialog" aria-labelledby="addVisitModalLabel" aria-hidden="true">
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
                        <input type="datetime-local" class="form-control" id="visit_date" name="visit_date" required>
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
                        <p class="mb-0">{{ __('عدد الزيارات') }}: <span id="currentVisitsCount" class="font-weight-bold"></span>/<span id="totalVisitsCount" class="font-weight-bold"></span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('إلغاء') }}</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="ft-save"></i> {{ __('حفظ') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- Toastr Notifications -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>
$(document).ready(function() {
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
        submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> {{ __("جاري الحفظ") }}');
        
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
                toastr.success(response.message || '{{ __("تمت إضافة الزيارة بنجاح") }}');
                
                // Reload the page to show updated data
                setTimeout(function() {
                    location.reload();
                }, 1500);
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).html('<i class="ft-save"></i> {{ __("حفظ") }}');
                
                if(xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    var errorMessage = '';
                    
                    $.each(errors, function(key, value) {
                        errorMessage += value + '<br>';
                    });
                    
                    toastr.error(errorMessage);
                } else {
                    toastr.error(xhr.responseJSON.message || '{{ __("حدث خطأ أثناء حفظ البيانات") }}');
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