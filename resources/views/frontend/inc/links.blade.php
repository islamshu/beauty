<script src="{{ asset('front/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('front/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('front/plugins/selectbox/jquery.selectbox-0.1.3.min.js') }}"></script>
<script src="{{ asset('front/plugins/owl-carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('front/plugins/isotope/isotope.min.js') }}"></script>


{{-- <script src="{{ asset('front/plugins/isotope/isotope-triger.min.js') }}"></script> --}}
<script src="{{ asset('front/plugins/datepicker/bootstrap-datepicker.min.js') }}"></script>

<script src="{{ asset('front/plugins/lazyestload/lazyestload.js') }}"></script>


<script src="{{ asset('front/plugins/smoothscroll/SmoothScroll.js') }}"></script>
<!-- Toastr CSS -->

<!-- Toastr JS -->
<link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/vendors/css/extensions/toastr.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/vendors/css/extensions/toastr.css') }}">
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>

<script src="{{ asset('front/js/custom.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@yield('scripts')

<script>
    //paste this code under head tag or in a seperate js file.
    // Wait for window load
    $(window).load(function() {
        // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");
    });
</script>

{{-- <link href="{{ asset('front/options/optionswitch.css') }}" rel="stylesheet">
<script src="{{ asset('front/options/optionswitcher.js') }}"></script> --}}
<script>
    // هذا الكود سيتعامل مع حالة #courses تلقائياً
    document.addEventListener('DOMContentLoaded', function() {
        // التحقق من الهاش عند تحميل الصفحة
        if (window.location.hash === '#courses') {
            activateCoursesNav();
        }

        // الاستماع لتغيرات الهاش
        window.addEventListener('hashchange', function() {
            if (window.location.hash === '#courses') {
                activateCoursesNav();
            }
        });

        function activateCoursesNav() {
            const navItem = document.getElementById('courses-nav-item');
            const navLink = navItem.querySelector('.nav-link');

            // إزالة التنشيط من جميع العناصر
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active');
            });

            // تفعيل العنصر الحالي
            navItem.classList.add('active');
            navLink.classList.add('active');
        }
    });
</script>

<!-- Slick Slider JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script src="{{ asset('backend/app-assets/vendors/js/extensions/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/js/scripts/extensions/toastr.js') }}" type="text/javascript"></script>
@if (session('success'))
    <script>
        toastr.success("{{ session('success') }}");
    </script>
@endif

@if (session('error'))
    <script>
        toastr.error("{{ session('error') }}");
    </script>
@endif
<script>
    toastr.options = {
        "closeButton": true, // عرض زر الإغلاق
        "progressBar": true, // عرض شريط التقدم
        "positionClass": "toast-top-right", // موقع الرسالة
        "timeOut": 5000, // مدة ظهور الرسالة (5 ثواني)
        "extendedTimeOut": 1000, // مدة إضافية عند التمرير فوق الرسالة
    };
</script>
<script>
    $(document).ready(function() {
        $(".owl-carousel").owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 5
                }
            }
        });
    });

    $(document).ready(function() {
        $("#owl-demo").owlCarousel({
            navigation: false,
            slideSpeed: 300,
            paginationSpeed: 500,
            items: 1,
            singleItem: true,
            autoPlay: 4000
        });



        $('.coursesSlider').slick({
            dots: true, // إظهار نقاط التمرير
            infinite: true, // تكرار العناصر
            speed: 300, // سرعة التمرير
            slidesToShow: 3, // عدد العناصر المعروضة في نفس الوقت
            slidesToScroll: 1, // عدد العناصر التي يتم التمرير عليها
            responsive: [{
                breakpoint: 1024, // على الشاشات المتوسطة
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                }
            }, {
                breakpoint: 768, // على الشاشات الصغيرة
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            }]
        });
    });
</script>
<script>
    function topFunction() {
        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    }
</script>
<script>
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();

            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                const offset = 100; // Adjust this value to offset the scroll position
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - offset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    $('#send_button_price').click(function() {
        let $btn = $(this);
        $btn.prop('disabled', true);
        $btn.html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> جاري الإرسال...'
        );

        var formData = $('#PriceingForm').serialize();
        $.ajax({
            url: "{{ route('package.purchase') }}",
            type: "POST",
            data: formData,
            success: function(response) {
                Swal.fire({
                    icon: "success",
                    title: "تم إرسال الطلب بنجاح!",
                    text: "سيتم التواصل معك قريبًا لإكمال العملية.",
                    confirmButtonText: "حسنًا"
                });
                // Reset the form correctly
                $('#PriceingForm')[0].reset();
                $btn.html('إرسال الطلب');
                $btn.prop('disabled', false);

                $('#PriceModal').modal('hide');
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
                    $btn.prop('disabled', false);
                    $btn.html('إرسال الطلب');
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "خطأ!",
                        text: "حدث خطأ غير متوقع، يرجى المحاولة لاحقًا",
                        confirmButtonText: "حسنًا"
                    });
                }
            }
        });
    });
    $("#enrollForm").submit(function(e) {
    e.preventDefault();
    let formData = $(this).serialize();
    let courseTitle = $(this).data('course-title');

    $(".text-danger").text("");

    $.ajax({
        url: "{{ route('course.enroll') }}",
        type: "POST",
        data: formData,
        success: function(response) {
            let whatsappNum = '{{ get_general_value('whatsapp_number') }}';
            
            // عرض رسالة النجاح مع زر متضمن
            Swal.fire({
                icon: 'success',
                title: 'تم التسجيل بنجاح!',
                html: `
                    <div class="alert alert-success mt-3">
                        <p class="mb-3">سنقوم بالتواصل معك قريباً</p>
                        <button onclick="window.open('https://wa.me/${whatsappNum}?text=${encodeURIComponent('أريد الاستفسار عن دورة ' + courseTitle)}', '_blank')"
                                class="btn btn-success w-100">
                            <i class="fab fa-whatsapp"></i> استفسر الآن عبر الواتساب
                        </button>
                    </div>
                `,
                confirmButtonText: 'حسناً',
                showCancelButton: false
            });

            $("#enrollForm")[0].reset();
            $("#enrollModal").modal('hide');
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    $(".error-" + key).text(value[0]);
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'حدث خطأ!',
                    text: 'يرجى المحاولة مرة أخرى أو التواصل عبر الواتساب',
                    confirmButtonText: 'موافق'
                });
            }
        }
    });
});

</script>

