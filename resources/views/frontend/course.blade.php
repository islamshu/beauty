@extends('layouts.frontend')

@section('content')
    <!-- قسم عرض بيانات الكورس -->
    <section class="course-details-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <!-- صورة الكورس -->
                    <div class="course-image-wrapper">
                        <img src="{{ asset('uploads/' . $course->image) }}" alt="{{ $course->title }}" style="max-width: 80%">
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- معلومات الكورس -->
                    <h2 class="course-title"><i class="fa fa-book"></i> {{ $course->title }}</h2>
                    <p class="course-description"><i class="fa fa-info-circle"></i> {!! $course->description !!}</p>
                    <h4 class="course-price"><i class="fa fa-dollar-sign"></i> ${{ $course->price }}</h4>

                    <!-- زر الاشتراك -->
                    <button class="btn btn-primary enroll-btn " style="padding: 20px" data-toggle="modal" data-target="#enrollModal">
                        <i class="fa fa-user-plus"></i> اشترك الآن
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- نافذة (Modal) الاشتراك -->
    <div class="modal fade" id="enrollModal" tabindex="-1" role="dialog" aria-labelledby="enrollModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="enrollModalLabel"><i class="fa fa-edit"></i> تسجيل الاشتراك في الكورس</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="enrollForm">
                        @csrf
                        <div class="form-group">
                            <label for="name"><i class="fa fa-user"></i> الاسم الكامل</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <span class="text-danger error-name"></span>
                        </div>
                        <div class="form-group">
                            <label for="phone"><i class="fa fa-phone"></i> رقم الهاتف</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                            <span class="text-danger error-phone"></span>
                        </div>
                        <div class="form-group">
                            <label for="address"><i class="fa fa-map-marker-alt"></i> العنوان</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                            <span class="text-danger error-address"></span>
                        </div>
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <div style="text-align: center">
                            <button style="background: #c21ea7;text-align: center;padding: 20px;" type="submit"
                            class="btn custom-btn ">
                            <i class="fa fa-paper-plane"></i> إرسال الطلب</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        /* تنسيق القسم الرئيسي */
        .course-details-section {
            padding: 60px 0;
            background: linear-gradient(to right, #1e3c72, #2a5298);
            color: #fff;
            text-align: center;
        }

        /* صورة الكورس */
        .course-image-wrapper {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .course-image {
            width: 100%;
            transition: transform 0.3s ease-in-out;
        }

        .course-image:hover {
            transform: scale(1.05);
        }

        /* معلومات الكورس */
        .course-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .custom-btn {
            background-color: #ff5722;
            /* لون برتقالي جميل */
            border-color: #ff5722;
            color: white;
            font-size: 18px;
            padding: 12px;
            border-radius: 5px;
            transition: background 0.3s ease-in-out, transform 0.2s ease;
        }

        .custom-btn:hover {
            background-color: #e64a19;
            /* لون أغمق عند التحويم */
            border-color: #e64a19;
            transform: scale(1.05);
        }

        .course-description {
            font-size: 18px;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .course-price {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* زر الاشتراك */
        .enroll-btn {
            font-size: 20px;
            padding: 12px 20px;
            border-radius: 5px;
            background: #f25fff;
            border: none;
            transition: background 0.3s ease;
        }

        .enroll-btn:hover {
            background: #f1168f;
        }

        /* تنسيق المودال */
        .modal-content {
            border-radius: 8px;
        }

        .modal-header {
            background: #007bff;
            color: white;
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-success {
            font-size: 18px;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $("#enrollForm").submit(function(e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $(".text-danger").text(""); // مسح الأخطاء السابقة

                $.ajax({
                    url: "{{ route('course.enroll') }}", // استبدل بالمسار الفعلي في routes
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'تم التسجيل بنجاح!',
                            text: 'سنتواصل معك قريبًا.',
                            confirmButtonText: 'حسنًا'
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
                                text: 'يرجى المحاولة مرة أخرى.',
                                confirmButtonText: 'موافق'
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
