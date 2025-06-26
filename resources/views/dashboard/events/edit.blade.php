@extends('layouts.master')

@section('title', 'تعديل الحجز')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">تعديل الحجز</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('reservations.index') }}">الحجوزات</a></li>
                            <li class="breadcrumb-item active">تعديل الحجز</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">
            <section class="card">
                <div class="card-header">
                    <h4 class="card-title">تعديل بيانات الحجز</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @include('dashboard.inc.alerts')

                        <form id="reservationForm" action="{{ route('reservations.update', $reservation->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- حقل العميل -->
                                <div class="col-md-6 form-group">
                                    <label for="client_id">اسم العميل <span class="text-danger">*</span></label>
                                    <select name="client_id" id="client_id" class="form-control select2" required>
                                        <option value="">اختر العميل</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}" {{ $reservation->client_id == $client->id ? 'selected' : '' }}>
                                                {{ $client->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- حقل الموظف -->
                                <div class="col-md-6 form-group">
                                    <label for="user_id">اسم الموظف <span class="text-danger">*</span></label>
                                    <select name="user_id" id="user_id" class="form-control select2" required>
                                        <option value="">اختر الموظف</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ $reservation->user_id == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- تاريخ ووقت الحجز -->
                            <div class="form-group">
                                <label class="font-weight-bold">تاريخ ووقت الحجز</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="date">التاريخ <span class="text-danger">*</span></label>
                                        <input type="date" name="date" id="date" class="form-control" value="{{ $date }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="start_time">وقت البدء <span class="text-danger">*</span></label>
                                        <input type="time" name="start_time" id="start_time" class="form-control" value="{{ $start }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="end_time">وقت الانتهاء <span class="text-danger">*</span></label>
                                        <input type="time" name="end_time" id="end_time" class="form-control" value="{{ $end }}" required>
                                    </div>
                                </div>
                                <div id="timeConflictAlert" class="alert alert-danger mt-2 d-none"></div>
                                <div id="loadingIndicator" class="text-center mt-2 d-none">
                                    <i class="fas fa-spinner fa-spin"></i> جاري التحقق من المواعيد...
                                </div>
                            </div>

                            <!-- عنوان الحجز -->
                            <div class="form-group">
                                <label for="title">عنوان الحجز <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $reservation->title) }}" required>
                            </div>

                            <!-- الخدمات -->
                            <div class="form-group">
                                <label for="services">الخدمات <span class="text-danger">*</span></label>
                                <select name="services[]" id="services" class="form-control select2" multiple required>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}" 
                                            {{ in_array($service->id, $reservation->services->pluck('id')->toArray()) ? 'selected' : '' }}>
                                            {{ $service->title }} - {{ $service->price }} شيكل
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- الملاحظات -->
                            <div class="form-group">
                                <label for="nots">ملاحظات</label>
                                <textarea name="nots" id="nots" class="form-control" rows="3">{{ old('nots', $reservation->nots) }}</textarea>
                            </div>

                            <!-- السبب -->
                            <div class="form-group">
                                <label for="reason">سبب الحجز</label>
                                <textarea name="reason" id="reason" class="form-control" rows="2">{{ old('reason', $reservation->reason) }}</textarea>
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> حفظ التعديلات
                                </button>
                                <a href="{{ route('reservations.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> إلغاء
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // تهيئة Select2
    $('.select2').select2({
        width: '100%',
        placeholder: "اختر",
        allowClear: true
    });

    let isLoading = false;

    // عند تغيير الموظف أو التاريخ
    $('#user_id, #date').change(function() {
        if (isLoading) return;
        
        const userId = $('#user_id').val();
        const date = $('#date').val();
        
        if (!userId || !date) {
            $('#start_time').val('');
            $('#end_time').val('');
            return;
        }
        
        fetchLastReservation(userId, date);
    });

    // جلب آخر حجز للموظف
    function fetchLastReservation(userId, date) {
        isLoading = true;
        $('#loadingIndicator').removeClass('d-none').show();
        $('#timeConflictAlert').addClass('d-none');

        $.ajax({
            url: '{{ route("reservations.getLastReservation") }}',
            method: 'GET',
            data: {
                user_id: userId,
                date: date,
                exclude_id: '{{ $reservation->id }}'
            },
            success: function(response) {
                if (response.lastReservation && response.lastReservation.end_time) {
                    $('#start_time').val(response.lastReservation.end_time);
                    const endTime = add90Minutes(response.lastReservation.end_time);
                    $('#end_time').val(endTime);
                } else {
                    // قيم افتراضية إذا لم يكن هناك حجوزات سابقة
                    $('#start_time').val('09:00');
                    $('#end_time').val('10:30');
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
            },
            complete: function() {
                isLoading = false;
                $('#loadingIndicator').addClass('d-none');
                checkReservationConflict();
            }
        });
    }

    // إضافة 90 دقيقة للوقت
    function add90Minutes(time) {
        if (!time) return '00:00';
        
        time = time.toString().trim();
        
        if (!/^\d{1,2}:\d{2}$/.test(time)) {
            throw new Error('صيغة الوقت غير صالحة. استخدم HH:MM');
        }
        
        let [hours, minutes] = time.split(':').map(Number);
        
        hours = isNaN(hours) ? 0 : hours;
        minutes = isNaN(minutes) ? 0 : minutes;
        
        minutes += 90;
        hours += Math.floor(minutes / 60);
        minutes = minutes % 60;
        hours = hours % 24;
        
        return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
    }

    // التحقق من التعارض
    function checkReservationConflict() {
        const date = $('#date').val();
        const start = $('#start_time').val();
        const end = $('#end_time').val();
        const userId = $('#user_id').val();

        if (!date || !start || !end || !userId) return;

        $.ajax({
            url: '{{ route("reservations.checkConflict") }}',
            method: 'POST',
            data: {
                date: date,
                start_time: start,
                end_time: end,
                user_id: userId,
                reservation_id: '{{ $reservation->id }}',
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status === 'conflict') {
                    const startTime = new Date(response.start).toLocaleTimeString('ar-EG', {hour: '2-digit', minute:'2-digit'});
                    const endTime = new Date(response.end).toLocaleTimeString('ar-EG', {hour: '2-digit', minute:'2-digit'});
                    
                    $('#timeConflictAlert').removeClass('d-none').html(
                        `⚠️ يوجد تعارض مع الحجز "${response.title}" من ${startTime} إلى ${endTime}`
                    );
                } else {
                    $('#timeConflictAlert').addClass('d-none');
                }
            }
        });
    }

    // التحقق عند تغيير المواعيد
    $('#start_time, #end_time').change(function() {
        checkReservationConflict();
        
        // التحقق من أن وقت النهاية بعد وقت البداية
        const start = $('#start_time').val();
        const end = $('#end_time').val();
        const date = $('#date').val();

        if (start && end && date) {
            if (new Date(`${date}T${end}`) <= new Date(`${date}T${start}`)) {
                alert('وقت النهاية يجب أن يكون بعد وقت البداية');
                $('#end_time').val('');
            }
        }
    });

    // تعيين القيم الأولية إذا كان هناك حجز سابق
    @if($lastReservation)
        $('#start_time').val('{{ Carbon\Carbon::parse($lastReservation->end)->format("H:i") }}');
        $('#end_time').val('{{ Carbon\Carbon::parse($lastReservation->end)->addMinutes(90)->format("H:i") }}');
    @endif
});
</script>
@endsection