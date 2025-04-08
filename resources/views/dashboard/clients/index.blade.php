@extends('layouts.master')
@section('title','العملاء')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('العملاء') }}</h3>
            </div>
        </div>
        <div class="content-body">
            <section>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('قائمة العملاء') }}</h4>
                        <a href="{{ route('clients.create') }}" class="btn btn-primary">{{ __('إضافة عميل جديد') }}</a>
                    </div>
                    <div class="card-body">
                        @include('dashboard.inc.alerts')
                        <table class="table" id="clientsTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('رمز QR') }}</th>

                                    <th>{{ __('الاسم') }}</th>
                                    <th>{{ __('رقم العضوية') }}</th>
                                    <th>{{ __('رقم الهاتف') }}</th>
                                    <th>الحالة</th>
                                    <th>{{ __('الإجراءات') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $key => $client)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td><img src="{{asset($client->qr_code)}}" width="80" height="80" alt=""></td>

                                        <td>{{ $client->name }}</td>
                                        <td>{{ $client->id_number }}</td>
                                        <td>{{ $client->phone }}</td>
                                        <td>
                                            @if ($client->activeSubscription)
                                                <div class="shadow-sm border rounded px-2 py-2 text-center" style="background: #f8f9fa;">
                                                    <div class="text-muted small mb-1">
                                                        حالة الاشتراك: 
                                                        <span class="font-weight-bold 
                                                            {{ $client->activeSubscription->status === 'active' ? 'text-success' : 
                                                                ($client->activeSubscription->status === 'suspended' ? 'text-warning' : 'text-danger') }}">
                                                            {{ __("subscription.status.{$client->activeSubscription->status}") }}
                                                        </span>
                                                    </div>
                                        
                                                    <div class="btn-group btn-group-sm" role="group" aria-label="Subscription Controls">
                                                        @if($client->activeSubscription->status !== 'active')
                                                            <form action="{{ route('subscriptions.activate', $client->activeSubscription) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="btn btn-outline-success" title="تفعيل">
                                                                    <i class="ft-check"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                        
                                                        
                                        
                                                        @if($client->activeSubscription->status !== 'canceled')
                                                        <form action="{{ route('subscriptions.cancel', $client->activeSubscription) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من إلغاء الاشتراك؟')">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-danger" title="إلغاء">
                                                                <i class="ft-x"></i>
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
                                        
                                        
                                        <td>
                                            <a href="{{ route('clients.show', $client->id) }}" class="btn btn-info">{{ __('عرض') }}</a>

                                            <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning">{{ __('تعديل') }}</a>

                                            <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('هل أنت متأكد؟') }}')">{{ __('حذف') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="addClientModal" tabindex="-1" role="dialog" aria-labelledby="addClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClientModalLabel">إضافة باقة للعميل</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addSubscriptionForm" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="client_id" id="modalClientId">
                    
                    <div class="form-group">
                        <label for="modal_package_id">الباقة</label>
                        <select name="package_id" id="modal_package_id" class="form-control" required>
                            <option value="">اختر الباقة</option>
                            @foreach($packages as $package)
                            <option value="{{ $package->id }}" 
                                data-duration="{{ $package->number_date }}" 
                                data-duration-type="{{ $package->type_date }}"
                                data-price="{{ $package->price }}"
                                data-visits="{{ $package->number_of_visits }}">
                                {{ $package->name }} ({{ $package->price }} شيكل)
                            </option>
                        @endforeach
                        </select>
                    </div>

                    <div id="subscriptionFields">
                        <div class="form-group">
                            <label for="modal_start_date">{{ __('تاريخ البدء') }}</label>
                            <input type="date" class="form-control" name="start_date" id="modal_start_date" required>
                        </div>
                        
                        <div class="form-group">
                            <label>{{ __('تاريخ الانتهاء') }}</label>
                            <input type="text" class="form-control" id="modal_end_date" readonly>
                            <small id="durationInfo" class="form-text text-muted"></small>
                        </div>
                        
                        <div class="form-group">
                            <label for="modal_payment_method">{{ __('طريقة الدفع') }}</label>
                            <select class="form-control" name="payment_method" id="modal_payment_method" required>
                                <option value="full">نقدي</option>
                                <option value="installments">تقسيط</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="modal_total_amount">{{ __('المبلغ الإجمالي') }}</label>
                            <input type="number" id="modal_total_amount" step="0.01" class="form-control" name="total_amount" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="modal_package_visit">{{ __('عدد الزيارات للباقة') }}</label>
                            <input type="number" id="modal_package_visit" step="1" class="form-control" name="package_visit" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="modal_paid_amount">{{ __('المبلغ المدفوع') }}</label>
                            <input type="number" step="0.01" class="form-control" name="paid_amount" id="modal_paid_amount" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
    // عند فتح المودال
    $('#addClientModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var clientId = button.data('client-id');
        $(this).find('#modalClientId').val(clientId);
        
        // تعيين تاريخ اليوم كتاريخ بدء افتراضي
        var today = new Date().toISOString().split('T')[0];
        $('#modal_start_date').val(today);
    });

    // عند تغيير الباقة
    $('#modal_package_id').change(function() {
        var selectedOption = $(this).find('option:selected');
        
        // إذا تم اختيار باقة (وليست الخيار الافتراضي)
        if ($(this).val()) {
            // جلب بيانات الباقة من خصائص data
            var packagePrice = selectedOption.data('price');
            var packageVisits = selectedOption.data('visits');
            // تعبئة الحقول تلقائياً
            $('#modal_total_amount').val(packagePrice);
            $('#modal_package_visit').val(packageVisits);
            
            // حساب تاريخ الانتهاء إذا كان تاريخ البدء محدد
            if ($('#modal_start_date').val()) {
                calculateEndDate();
            }
            
            // عرض معلومات المدة
            var duration = selectedOption.data('duration');
            var durationType = selectedOption.data('duration-type');
            $('#durationInfo').text(`مدة الباقة: ${duration} ${getDurationText(durationType)}`);
        } else {
            // إذا لم يتم اختيار باقة، مسح الحقول
            $('#modal_total_amount').val('');
            $('#modal_package_visit').val('');
            $('#modal_end_date').val('');
            $('#durationInfo').text('');
        }
    });


    // عند تغيير تاريخ البدء
    $('#modal_start_date').change(function() {
        if ($('#modal_package_id').val()) {
            calculateEndDate();
        }
    });

    // دالة لحساب تاريخ الانتهاء
    function calculateEndDate() {
        var packageId = $('#modal_package_id').val();
        var startDate = $('#modal_start_date').val();
        
        if (!packageId || !startDate) return;
        let url = "{{ route('packages.calculate-end-date', ['package' => ':packageId']) }}".replace(':packageId',
        packageId);
        $.ajax({
            url: url,
            method: "GET",
            data: {
                package: packageId,
                start_date: startDate
            },
            success: function(response) {
                $('#modal_end_date').val(response.end_date);
            },
            error: function(xhr) {
                console.error('Error calculating end date:', xhr.responseText);
            }
        });
    }

    // دالة مساعدة للحصول على نص المدة
    function getDurationText(type) {
        switch(type) {
            case 'day': return 'يوم';
            case 'week': return 'أسبوع';
            case 'month': return 'شهر';
            case 'year': return 'سنة';
            default: return '';
        }
    }

    // إرسال النموذج
    $('#addSubscriptionForm').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: "{{ route('subscriptions.store') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                $('#addClientModal').modal('hide');
                toastr.success(response.message || '{{ __("تمت إضافة الباقة بنجاح") }}');
                
                setTimeout(function() {
                    location.reload();
                }, 1500);
            },
           
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                var errorMessages = '';
                
                $.each(errors, function(key, value) {
                    errorMessages += value + '<br>';
                });
                
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    html: errorMessages,
                });
            }
        });
    });
});
</script>
@endsection