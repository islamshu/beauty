@extends('layouts.frontend')
@section('content')
    @include('frontend.sections.sliders')
    @include('frontend.sections.about')
    @include('frontend.sections.service')
    @include('frontend.sections.packge')
    @include('frontend.sections.gallery')

    @include('frontend.sections.course')

    @include('frontend.sections.team')
    {{-- @include('frontend.sections.review') --}}
    @include('frontend.sections.product')
    @include('frontend.sections.partner')
@endsection
@section('scripts')
    <!-- تضمين مكتبة SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0.1/dist/fancybox.umd.js"></script>

    <script>
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel({
                items: 1,
                loop: true,
                autoplay: true,
                autoplayTimeout: 7000,
                nav: true,
                dots: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    1000: {
                        items: 1
                    }
                }
            });
            $(".enroll-btn").click(function() {
                var courseId = $(this).data("course-id");
                var courseTitle = $(this).data("course-title");

                $("#course-id").val(courseId);
                $("#course-name").text(courseTitle);

                $("#enrollmentModal").modal("show");
            });

            $("#enrollmentForm").submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('course.enroll') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status === "success") {
                            Swal.fire({
                                icon: "success",
                                title: "تم الاشتراك بنجاح!",
                                text: "تم تسجيلك في الدورة بنجاح.",
                                confirmButtonText: "حسنًا"
                            });

                            $("#enrollmentModal").modal("hide");
                            $("#enrollmentForm")[0].reset();
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: "error",
                            title: "خطأ!",
                            text: "حدث خطأ أثناء الاشتراك، يرجى المحاولة مرة أخرى.",
                            confirmButtonText: "حسنًا"
                        });
                    }
                });
            });
            // استدعاء أول خدمة تلقائيًا عند تحميل الصفحة
            const firstServiceId = @json($first_service->id);
            if (firstServiceId) {
                fetchServiceDetails(firstServiceId);
            }

            function fetchServiceDetails(serviceId) {
                $('#varietyContent').html(
                    '<div class="text-center"><i class="fa fa-spinner fa-spin"></i> جاري التحميل...</div>'
                );

                $.ajax({
                    url: "{{ route('service_show', ':service') }}".replace(':service', serviceId),
                    method: 'GET',
                    success: function(response) {
                        $('#varietyContent').html(`
                        <img src="${response.image}" alt="${response.title}" class="img-responsive lazyestload">
                        <h3>${response.title}</h3>
                        <h4>$${response.price} لكل شخص</h4>
                        <p>${response.description}</p>
                        <a href="javascript:void(0)" class="btn btn-primary first-btn make-appointment-btn" 
                           style="padding: 10px; border-radius: 5%;" 
                           data-service-id="${response.id}" 
                           data-service-title="${response.title}" 
                           data-service-price="${response.price}" 
                           data-toggle="modal" 
                           data-target="#appoinmentModal">
                            احجز موعدًا
                        </a>
                    `);
                    },
                    error: function(xhr, status, error) {
                        console.error('خطأ في جلب تفاصيل الخدمة:', error);
                        $('#varietyContent').html(
                            '<p>حدث خطأ أثناء تحميل تفاصيل الخدمة. حاول مرة أخرى.</p>');
                    }
                });
            }

            // عند النقر على تبويب الخدمة
            $('.service-tab').on('click', function() {
                $('.service-tab').removeClass('active');
                $(this).addClass('active');

                const serviceId = $(this).data('service-id');
                fetchServiceDetails(serviceId);
            });

            // عند الضغط على زر "احجز موعدًا"
            $(document).on('click', '.make-appointment-btn', function() {
                const serviceId = $(this).data('service-id');
                const serviceTitle = $(this).data('service-title');

                // تحديث الـ Modal
                $('.appointment-modal-title').text(`حجز موعد لخدمة: ${serviceTitle}`);

                // تحديث الحقل المخفي داخل الفورم
                $('#service-id').val(serviceId);
            });

            // إرسال بيانات الحجز
            $("#send_button").click(function(e) {
                e.preventDefault(); // منع إعادة تحميل الصفحة

                let formData = $("#appoinmentModalForm").serialize(); // جمع بيانات الفورم

                // إزالة الأخطاء القديمة
                $(".text-danger").text("");

                $.ajax({
                    url: "{{ route('appointment.store') }}", // مسار API الحجز
                    type: "POST",
                    data: formData,
                    headers: {
                        "X-CSRF-TOKEN": $('input[name="_token"]').val() // حماية CSRF
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "تم الحجز بنجاح!",
                            text: "تم تأكيد موعدك بنجاح.",
                            confirmButtonText: "حسنًا"
                        });

                        $("#appoinmentModalForm")[0].reset(); // إعادة تعيين الفورم
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) { // أخطاء التحقق
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $(".error-" + key).text(value[
                                    0]); // عرض الخطأ تحت الحقل
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "خطأ!",
                                text: "حدث خطأ غير متوقع، يرجى المحاولة مرة أخرى.",
                                confirmButtonText: "حسنًا"
                            });
                        }
                    }
                });
            });

            // عند الضغط على زر "اشتري الآن"
            $('.openModalBtn').click(function() {
                var packageId = $(this).data('id');
                var packageName = $(this).data('name');

                $('#package-id').val(packageId);
                $('#package-title').text(packageName);
            });

            // إرسال بيانات شراء الباقة
           

        });
    </script>
@endsection
