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
                let formData = {
                    "_token": "{{ csrf_token() }}",
                    "contact-form-name": $("#name").val(),
                    "contact-form-email": $("#email").val(),
                    "contact-form-mobile": $("#mobile").val(),
                    "contact-form-message": $("#message").val(),
                };

                $.ajax({
                    url: "{{ route('contact.store') }}", // Adjust your route
                    method: "POST",
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: "success",
                                title: "تم بنجاح!",
                                text: response.message,
                                confirmButtonText: "حسنًا"
                            });
                            $("#angelContactForm")[0].reset(); // Reset form fields
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        let firstErrorMessage = Object.values(errors)[0][
                            0
                        ]; // Get the first error message

                        Swal.fire({
                            icon: "error",
                            title: "خطأ!",
                            text: firstErrorMessage, // Show only the first error
                            confirmButtonText: "حسنًا"
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $("#checkoutForm").submit(function(event) {
            event.preventDefault(); // منع التحديث التلقائي للصفحة

            $.ajax({
                url: "{{ route('checkout') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    customer_name: $('#customer_name').val(),
                    customer_phone: $('#customer_phone').val(),
                    customer_id: $('#customer_id').val(),
                    customer_address: $('#customer_address').val(),
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: "success",
                            title: "تم بنجاح!",
                            text: "تم إتمام الطلب بنجاح، سيتم تحويلك إلى صفحة النجاح بعد قليل...",
                            confirmButtonText: "حسنًا",
                            timer: 3000, // إغلاق التنبيه تلقائيًا بعد 3 ثوانٍ
                            didClose: () => {
                                window.location.href = "{{ route('orders.success') }}";
                            }
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errorMessage = xhr.responseJSON.message; // عرض أول خطأ فقط
                        Swal.fire({
                            icon: "error",
                            title: "خطأ!",
                            text: errorMessage,
                            confirmButtonText: "حسنًا"
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
