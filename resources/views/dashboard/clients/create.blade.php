@extends('layouts.master')
@section('title','اضافة عميل')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('اضافة عميل') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">{{ __('العملاء') }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('اضافة عميل') }}</li>
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

                            <form id="clientForm">
                                @csrf
                                <div class="card">
                                    <div class="card-header">إضافة عميل جديد</div>
                                    <div class="card-body">
                                        <!-- الخطوة 1: بيانات العميل -->
                                        <div class="step step-1">
                                            <h5>بيانات العميل</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>اسم العميل *</label>
                                                    <input type="text" class="form-control" name="name" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>رقم الهاتف *</label>
                                                    <input type="text" class="form-control" name="phone" id="phone"
                                                        required>
                                                    <small id="phone-error" class="text-danger"></small>
                                                </div>
                                                <div class="col-md-12">
                                                    <label>عنوان العميل *</label>
                                                    <textarea class="form-control" name="address" required></textarea>
                                                </div>
                                            </div>
                                            <br>
                                            <button type="button" class="btn btn-success save-client">حفظ</button>
                                            <button type="button" class="btn btn-primary next-step">إضافة اشتراك</button>
                                        </div>

                                        <!-- الخطوة 2: إضافة اشتراك -->
                                        <div class="step step-2 d-none">
                                            <h5>إضافة اشتراك</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>اختر الباقة *</label>
                                                    <select class="form-control" name="package" id="package" required>
                                                        <option value="">اختر الباقة</option>
                                                        @foreach ($packages as $package)
                                                            <option value="{{ $package->id }}"
                                                                data-price="{{ $package->price }}">
                                                                {{ $package->name }} - {{ $package->price }} شيكل
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>طريقة الدفع *</label>
                                                    <select class="form-control" name="payment_method" id="payment_method"
                                                        required>
                                                        <option value="full">دفع كامل</option>
                                                        <option value="installments">دفع على دفعات</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 d-none" id="installments_amount">
                                                    <label>المبلغ المدفوع *</label>
                                                    <input type="number" class="form-control" name="paid_amount">
                                                    <small>المبلغ الكلي: <span id="total_amount">0</span> شيكل</small>
                                                </div>
                                            </div>
                                            <br>
                                            <button type="button" class="btn btn-secondary prev-step">السابق</button>
                                            <button type="submit" class="btn btn-success">إتمام الاشتراك</button>
                                        </div>
                                    </div>
                                </div>
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
        $(document).ready(function() {
            let currentStep = 1;

            // زر حفظ - حفظ بيانات العميل فقط والانتقال إلى قائمة العملاء
            $(".save-client").click(function() {
                if (validateStep(1)) {
                    saveClientData(false); // حفظ فقط بدون اشتراك
                }
            });

            // زر إضافة اشتراك - حفظ العميل ثم إضافة اشتراك
            $(".next-step").click(function() {
                if (validateStep(1)) {
                    checkPhoneNumber();
                }
            });

            // العودة للخطوة السابقة
            $(".prev-step").click(function() {
                showStep(currentStep - 1);
            });

            // إظهار حقل المبلغ المدفوع عند اختيار الدفع بالتقسيط
            $("#payment_method").change(function() {
                if ($(this).val() === "installments") {
                    $("#installments_amount").removeClass("d-none");
                } else {
                    $("#installments_amount").addClass("d-none");
                }
            });

            // التحقق من رقم الهاتف قبل الانتقال للخطوة 2
            function checkPhoneNumber() {
                let phone = $("#phone").val();
                $.ajax({
                    url: "{{ route('check.phone') }}",
                    type: "POST",
                    data: {
                        phone: phone,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.exists) {
                            $("#phone-error").text("رقم الهاتف موجود مسبقًا.");
                        } else {
                            showStep(currentStep + 1);
                        }
                    }
                });
            }
            $("#clientForm").submit(function(event) {
                event.preventDefault(); // منع الإرسال الافتراضي للنموذج

                saveClientData(true); // حفظ العميل مع الاشتراك
            });

            // حفظ بيانات العميل فقط أو مع الاشتراك
            function saveClientData(withSubscription = false) {
                $.ajax({
                    url: "{{ route('clients.store') }}",
                    type: "POST",
                    data: $("#clientForm").serialize(),
                    success: function(response) {
                        toastr.success("تم حفظ بيانات العميل بنجاح!", "نجاح");

                        if (withSubscription) {
                            // إكمال الاشتراك بعد الحفظ
                            completeSubscription(response.client_id);
                        } else {
                            // الانتقال إلى قائمة العملاء بعد الحفظ فقط
                            setTimeout(function() {
                                window.location.href = "{{ route('clients.index') }}";
                            }, 1500);
                        }
                    },
                    error: function(xhr) {
                        handleValidationErrors(xhr);
                    }
                });
            }

            // إكمال عملية الاشتراك
            function completeSubscription(clientId) {
                $.ajax({
                    url: "{{ route('clients.subscribe') }}",
                    type: "POST",
                    data: {
                        client_id: clientId,
                        package: $("#package").val(),
                        payment_method: $("#payment_method").val(),
                        paid_amount: $("#payment_method").val() === "installments" ? $(
                            "input[name='paid_amount']").val() : null,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.success(response.message, "نجاح");
                        setTimeout(function() {
                            window.location.href = "{{ route('clients.index') }}";
                        }, 1500);
                    },
                    error: function(xhr) {
                        handleValidationErrors(xhr);
                    }
                });
            }

            // التحقق من الحقول المطلوبة
            function validateStep(step) {
                let valid = true;
                $(".step-" + step + " [required]").each(function() {
                    if (!$(this).val()) {
                        $(this).addClass("is-invalid");
                        valid = false;
                    } else {
                        $(this).removeClass("is-invalid");
                    }
                });
                return valid;
            }

            // عرض الخطوة المحددة فقط
            function showStep(step) {
                $(".step").addClass("d-none");
                $(".step-" + step).removeClass("d-none");
                currentStep = step;
            }

            // معالجة أخطاء التحقق
            function handleValidationErrors(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $(".is-invalid").removeClass("is-invalid");
                    $(".invalid-feedback").remove();

                    $.each(errors, function(field, messages) {
                        let input = $(`[name="${field}"]`);
                        input.addClass("is-invalid");
                        input.after(`<div class="invalid-feedback">${messages[0]}</div>`);
                    });

                    toastr.error("يرجى التحقق من البيانات المدخلة.", "خطأ");
                } else {
                    toastr.error("حدث خطأ أثناء العملية!", "خطأ");
                }
            }

        });
    </script>
@endsection
