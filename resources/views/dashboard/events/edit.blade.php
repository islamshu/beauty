@extends('layouts.master')
@section('title','تعديل الحجز')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('تعديل حجز') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('reservations.index') }}">{{ __('الحجوزات') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('تعديل حجز') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <section>
                    <div class="card">
                        <div class="card-body">
                            @include('dashboard.inc.alerts')

                            <form action="{{ route('reservations.update', $reservation->id) }}" method="POST" id="reservationForm">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="client_id">{{ __('اسم الزبون') }} <span class="required">*</span></label>
                                            <select name="client_id" id="client_id" class="form-control select2" required>
                                                <option value="" disabled>{{ __('اختر العميل') }}</option>
                                                @foreach ($clients as $client)
                                                    <option value="{{ $client->id }}" {{ $reservation->client_id == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('client_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">{{ __('عنوان الحجز') }} <span class="required">*</span></label>
                                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $reservation->title) }}" required>
                                            @error('title')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="start">{{ __('تاريخ البداية') }} <span class="required">*</span></label>
                                            <input type="datetime-local" name="start" id="start" class="form-control" value="{{ old('start', $reservation->start) }}" required>
                                            @error('start')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="end">{{ __('تاريخ النهاية') }} <span class="required">*</span></label>
                                            <input type="datetime-local" name="end" id="end" class="form-control" value="{{ old('end', $reservation->end) }}" required>
                                            @error('end')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="user_id">{{ __('اسم الموظف') }} <span class="required">*</span></label>
                                            <select name="user_id" id="user_id" class="form-control select2" required>
                                                <option value="" disabled>{{ __('اختر المستخدم') }}</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}" {{ $reservation->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('user_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="services">{{ __('الخدمات') }} <span class="required">*</span></label>
                                            <select name="services[]" id="services" class="form-control select2" multiple required>
                                                @foreach ($services as $service)
                                                    <option value="{{ $service->id }}" {{ in_array($service->id, $reservation->services->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $service->title }} - {{ $service->price }} ريال</option>
                                                @endforeach
                                            </select>
                                            @error('services')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="nots">{{ __('الملاحظات') }}</label>
                                    <textarea name="nots" id="nots" class="form-control">{{ old('nots', $reservation->nots) }}</textarea>
                                    @error('nots')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="reason">{{ __('السبب') }}</label>
                                    <textarea name="reason" id="reason" class="form-control">{{ old('reason', $reservation->reason) }}</textarea>
                                    @error('reason')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-success">{{ __('تحديث الحجز') }}</button>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
    // تهيئة Select2
    $('.select2').select2({
        placeholder: "{{ __('اختر') }}",
        allowClear: true
    });

    // دالة التحقق من Select2
    function validateSelect2Field(selector) {
        let select2Element = $(selector);
        let parentDiv = select2Element.closest('.form-group'); // البحث عن أقرب div يحتوي على input
        let errorMessage = parentDiv.find('.select2-error-message');

        if (select2Element.val() === null || select2Element.val().length === 0) {
            parentDiv.find('.select2-selection').css('border', '2px solid red'); // إضافة إطار أحمر
            if (errorMessage.length === 0) {
                parentDiv.append('<small class="text-danger select2-error-message">{{ __("هذا الحقل مطلوب") }}</small>');
            }
            return false;
        } else {
            parentDiv.find('.select2-selection').css('border', ''); // إزالة الإطار الأحمر
            errorMessage.remove(); // حذف رسالة الخطأ
            return true;
        }
    }

    // تحديث التحقق عند تغيير القيم
    $('#client_id, #user_id, #services').on('change', function () {
        validateSelect2Field(this);
    });

    // التحقق عند إرسال النموذج
    $('#reservationForm').on('submit', function (e) {
        let isValid = true;

        if (!validateSelect2Field('#client_id')) isValid = false;
        if (!validateSelect2Field('#user_id')) isValid = false;
        if (!validateSelect2Field('#services')) isValid = false;

        // إلغاء الإرسال إذا كان هناك خطأ
        if (!isValid) {
            e.preventDefault();
            alert("{{ __('يرجى ملء جميع الحقول المطلوبة') }}");
        }
    });
});

</script>
@endsection