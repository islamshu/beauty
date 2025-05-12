<!DOCTYPE html>
<html lang="en">


<meta http-equiv="content-type" content="text/html;charset=utf-8" />

@include('frontend.inc.head')

<body id="body" class="body-wrapper static rtl">
    <div class="se-pre-con"></div>
    <div class="main-wrapper">
        @include('frontend.inc.header')
        <!-- HEADER -->
        @yield('content')



        {{-- <!-- CALL TO ACTION SECTION -->
        <section class="clearfix callAction">
            <div class="container">
                <div class="row">
                    <div class="col-sm-7 col-sm-offset-1 col-xs-12">
                        <div class="callInfo">
                            <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum sed ut perspiciatis.</p>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <a href="pricing.html" class="btn btn-primary first-btn callBtn">view packages</a>
                    </div>
                </div>
            </div>
        </section> --}}

        <!-- EXPERT SECTION -->
        <!-- PARTNER LOGO SECTION -->













        <!-- FOOTER -->
        @include('frontend.inc.footer')

    </div>


    <!-- FANCY SEARCH -->



    <!-- JAVASCRIPTS -->
    @include('frontend.inc.links')
    @yield('scripts')
    <script>
        $(document).ready(function() {
            $("#submitBtn").click(function() {
                // تعطيل الزر وإضافة مؤشر تحميل
                let $btn = $(this);
                $btn.prop('disabled', true);
                $btn.html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> جاري الإرسال...'
                );

                // مسح رسائل الخطأ السابقة
                $('.error-message').remove();
                $('.form-control').removeClass('is-invalid');

                let formData = {
                    "_token": "{{ csrf_token() }}",
                    "contact-form-name": $("#name").val(),
                    "contact-form-email": $("#email").val(),
                    "contact-form-mobile": $("#mobile").val(),
                    "contact-form-message": $("#message").val(),
                };

                $.ajax({
                    url: "{{ route('contact.store') }}",
                    method: "POST",
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "تم بنجاح!",
                            text: response.message,
                            confirmButtonText: "حسنًا",
                            timer: 3000
                        });
                        $("#angelContactForm")[0].reset();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessages = [];

                            // جمع جميع رسائل الخطأ
                            $.each(errors, function(field, messages) {
                                errorMessages = errorMessages.concat(messages);

                                // عرض الأخطاء تحت الحقول (اختياري)
                                let $field = $(`#${field}`);
                                $field.addClass('is-invalid');
                                $field.after(
                                    `<div class="error-message text-danger mt-2">${messages.join('<br>')}</div>`
                                );
                            });

                            // عرض جميع الأخطاء في SweetAlert
                            Swal.fire({
                                icon: "error",
                                title: "خطأ في الإرسال",
                                html: errorMessages.join('<br>'),
                                confirmButtonText: "حسنًا"
                            });

                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "خطأ!",
                                text: "حدث خطأ غير متوقع، يرجى المحاولة لاحقاً",
                                confirmButtonText: "حسنًا"
                            });
                        }
                    },
                    complete: function() {
                        $btn.prop('disabled', false);
                        $btn.html('إرسال الرسالة');
                    }
                });
            });
        });
    </script>
    <script>
        $('#submitOrderBtn').on('click', function() {
            event.preventDefault(); // 👈 هذا السطر مهم جدًا لمنع الفورم من الإرسال التلقائي

            $('.text-danger').remove();
            $('.is-invalid').removeClass('is-invalid');
            $('.error-customer_phone').text('');

            // تحقق يدوي من القيم
            let name = $('#customer_name').val().trim();
            let phone = $('#phoneNumber').val().trim();
            let country = $('#country_code').val();
            let fullPhone = country + phone.replace(/^0/, '');
            let address = $('#customer_address').val().trim();
            let area = $('#customer_area').val();
            let hasError = false;

            // التحقق من الاسم
            if (name === "") {
                $('#customer_name').addClass('is-invalid').after('<div class="text-danger">الاسم مطلوب</div>');
                hasError = true;
            }

            // التحقق من الهاتف
            // التحقق من الهاتف
            if (!/^0\d{9}$/.test(phone)) {
                $('#phoneNumber').addClass('is-invalid');
                $('.error-customer_phone').text("يجب أن يبدأ الرقم بـ 0 ويحتوي على 10 أرقام");
                hasError = true;
            }


            // التحقق من العنوان
            if (address === "") {
                $('#customer_address').addClass('is-invalid').after('<div class="text-danger">العنوان مطلوب</div>');
                hasError = true;
            }

            // التحقق من المنطقة
            if (!area) {
                $('#customer_area').addClass('is-invalid').after(
                    '<div class="text-danger">يرجى اختيار المنطقة</div>');
                hasError = true;
            }

            if (hasError) return;
            // إرسال البيانات عبر AJAX
            $.ajax({
                url: "{{ route('checkout') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    customer_name: name,
                    customer_phone: fullPhone,
                    customer_address: address,
                    area: area,
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: "success",
                            title: "تم بنجاح!",
                            text: "تم إتمام الطلب بنجاح، سيتم تحويلك إلى صفحة النجاح بعد قليل...",
                            confirmButtonText: "حسنًا",
                            timer: 3000,
                            didClose: () => {
                                window.location.href = "{{ route('orders.success') }}";
                            }
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            let input = $('[name="' + field + '"]');
                            input.addClass('is-invalid');

                            if (field === 'customer_phone') {
                                $('.error-customer_phone').text(messages[0]);
                            } else {
                                input.after('<div class="text-danger">' + messages[0] +
                                    '</div>');
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "خطأ!",
                            text: "حدث خطأ غير متوقع، يرجى المحاولة لاحقًا.",
                            confirmButtonText: "حسنًا"
                        });
                    }
                }
            });
        });
        $('#submitProductBtn').on('click', function() {
            event.preventDefault(); // 👈 هذا السطر مهم جدًا لمنع الفورم من الإرسال التلقائي

            $('.text-danger').remove();
            $('.is-invalid').removeClass('is-invalid');
            $('.error-customer_phone').text('');

            // تحقق يدوي من القيم
            let name = $('#customer_name').val().trim();
            let phone = $('#phoneNumber').val().trim();
            let country = $('#country_code').val();
            let fullPhone = country + phone.replace(/^0/, '');
            let address = $('#customer_address').val().trim();
            let area = $('#customer_area').val();
            let hasError = false;
            let product_id = $('#product_single').val();
            // التحقق من الاسم
            if (name === "") {
                $('#customer_name').addClass('is-invalid').after('<div class="text-danger">الاسم مطلوب</div>');
                hasError = true;
            }

            // التحقق من الهاتف
            // التحقق من الهاتف
            if (!/^0\d{9}$/.test(phone)) {
                $('#phoneNumber').addClass('is-invalid');
                $('.error-customer_phone').text("يجب أن يبدأ الرقم بـ 0 ويحتوي على 10 أرقام");
                hasError = true;
            }


            // التحقق من العنوان
            if (address === "") {
                $('#customer_address').addClass('is-invalid').after('<div class="text-danger">العنوان مطلوب</div>');
                hasError = true;
            }

            // التحقق من المنطقة
            if (!area) {
                $('#customer_area').addClass('is-invalid').after(
                    '<div class="text-danger">يرجى اختيار المنطقة</div>');
                hasError = true;
            }

            if (hasError) return;
            // إرسال البيانات عبر AJAX
            $.ajax({
                url: "{{ route('checkout_single') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    customer_name: name,
                    customer_phone: fullPhone,
                    customer_address: address,
                    area: area,
                    product_id:product_id
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: "success",
                            title: "تم بنجاح!",
                            text: "تم إتمام الطلب بنجاح، سيتم تحويلك إلى صفحة النجاح بعد قليل...",
                            confirmButtonText: "حسنًا",
                            timer: 3000,
                            didClose: () => {
                                window.location.href = "{{ route('orders.success') }}";
                            }
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            let input = $('[name="' + field + '"]');
                            input.addClass('is-invalid');

                            if (field === 'customer_phone') {
                                $('.error-customer_phone').text(messages[0]);
                            } else {
                                input.after('<div class="text-danger">' + messages[0] +
                                    '</div>');
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "خطأ!",
                            text: "حدث خطأ غير متوقع، يرجى المحاولة لاحقًا.",
                            confirmButtonText: "حسنًا"
                        });
                    }
                }
            });
        });
    </script>



</body>



</html>
