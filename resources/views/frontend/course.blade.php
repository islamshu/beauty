@extends('layouts.frontend')

@section('content')
    <!-- Hero Section -->
    

    <!-- Course Details Section -->
    <section class="course-details-section py-5">
        <!-- القسم العلوي الجديد -->
        <div class="container mb-5">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="course-main-title mb-3">{{ $course->title }}</h1>
                    <p class="course-main-subtitle lead mb-4">احترف فن تصفيف الشعر مع أفضل المدربين</p>
                    <button class="btn btn-primary enroll-btn" data-toggle="modal" data-target="#enrollModal">
                        <i class="fas fa-scissors"></i> سجل الآن
                    </button>
                </div>
            </div>
        </div>
    
        <!-- القسم الأصلي الموجود -->
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="gallery-container">
                        <div class="main-image mb-3">
                            <img src="{{ asset('uploads/' . $course->image) }}" alt="{{ $course->title }}" class="img-fluid rounded shadow">
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="course-info-card p-4 shadow rounded">
                        <h2 class="section-title"><i class="fas fa-cut"></i> تفاصيل الدورة</h2>
                        <div class="course-highlights">
                            <div class="highlight-item">
                                <i class="fas fa-certificate"></i>
                                <span>شهادة معتمدة</span>
                            </div>
                            <div class="highlight-item">
                                <i class="fas fa-user-tie"></i>
                                <span>مدربين محترفين</span>
                            </div>
                        </div>
                        
                        <div class="course-description mt-4">
                            {!! $course->description !!}
                        </div>
                        
                        <div class="price-section mt-4">
                            <h3 class="price">${{ $course->price }}</h3>
                            <p class="installment">أو دفعات شهرية بـ ${{ number_format($course->price/3, 2) }}</p>
                        </div>
                        
                        <button class="btn btn-primary enroll-btn w-100" data-toggle="modal" data-target="#enrollModal">
                            <i class="fas fa-scissors"></i> احجز مقعدك الآن
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <style>
        /* تنسيق القسم العلوي الجديد */
        .course-main-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
        }
        .course-main-subtitle {
            font-size: 1.25rem;
            color: #666;
        }
        .enroll-btn {
            background: #d63384;
            border: none;
            padding: 12px 30px;
            font-size: 1.1rem;
            transition: all 0.3s;
        }
        .enroll-btn:hover {
            background: #a52d6b;
            transform: translateY(-3px);
        }
        
        /* الحفاظ على التنسيقات الأصلية */
        .course-info-card {
            background: white;
            border-top: 5px solid #d63384;
        }
        .section-title {
            color: #d63384;
            font-weight: 700;
        }
        .highlight-item i {
            color: #d63384;
            margin-left: 10px;
        }
        .price {
            color: #d63384;
            font-weight: 700;
        }
    </style>

    <!-- Curriculum Section -->
  

   

    <!-- Enrollment Modal -->
    <div class="modal fade" id="enrollModal" tabindex="-1" role="dialog" aria-labelledby="enrollModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="enrollModalLabel"><i class="fas fa-scissors"></i> تسجيل في دورة تصفيف الشعر</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="enrollForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name"><i class="fas fa-user"></i> الاسم الكامل</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                    <span class="text-danger error-name"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone"><i class="fas fa-phone"></i> رقم الهاتف</label>
                                    <input type="text" class="form-control" id="phone" name="phone" required>
                                    <span class="text-danger error-phone"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="experience"><i class="fas fa-star"></i> مستوى خبرتك في التصفيف</label>
                            <select class="form-control" id="experience" name="experience">
                                <option value="beginner">مبتدئ</option>
                                <option value="intermediate">متوسط</option>
                                <option value="advanced">متقدم</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="goal"><i class="fas fa-bullseye"></i> هدفك من الدورة</label>
                            <textarea class="form-control" id="goal" name="goal" rows="2"></textarea>
                        </div>
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane"></i> إرسال الطلب
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
    /* Hero Section */
    .hero-section {
        padding: 120px 0;
        color: white;
        text-align: center;
    }
    .hero-title {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 20px;
    }
    .hero-subtitle {
        font-size: 1.5rem;
        margin-bottom: 30px;
    }
    
    /* Course Info */
    .course-info-card {
        background: white;
        border-top: 5px solid #d63384;
    }
    .section-title {
        color: #d63384;
        font-weight: 700;
        margin-bottom: 25px;
        position: relative;
    }
    .section-title:after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 50px;
        height: 3px;
        background: #d63384;
    }
    .course-highlights {
        margin-bottom: 20px;
    }
    .highlight-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    .highlight-item i {
        color: #d63384;
        margin-left: 10px;
    }
    .price-section {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        text-align: center;
        margin: 25px 0;
    }
    .price {
        color: #d63384;
        font-size: 2rem;
        font-weight: 700;
    }
    .installment {
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    /* Curriculum */
    .icon-circle {
        width: 50px;
        height: 50px;
        background: #d63384;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    .item-topics {
        list-style: none;
        padding-right: 0;
    }
    .item-topics li {
        margin-bottom: 8px;
        position: relative;
        padding-right: 25px;
    }
    .item-topics li i {
        color: #d63384;
        position: absolute;
        right: 0;
    }
    
    /* Gallery */
    .thumbnail-gallery {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 10px;
    }
    .thumbnail-gallery img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        cursor: pointer;
        transition: transform 0.3s;
    }
    .thumbnail-gallery img:hover {
        transform: scale(1.1);
    }
    
    /* Testimonials */
    .testimonial-card {
        background: white;
        border-radius: 10px;
        max-width: 800px;
        margin: 0 auto;
    }
    .testimonial-text {
        font-size: 1.1rem;
        font-style: italic;
        position: relative;
    }
    .testimonial-text:before, .testimonial-text:after {
        content: '"';
        color: #d63384;
        font-size: 1.5rem;
    }
    
    /* Buttons */
    .enroll-btn {
        background: #d63384;
        border: none;
        padding: 12px 30px;
        font-size: 1.1rem;
        font-weight: 600;
        transition: all 0.3s;
    }
    .enroll-btn:hover {
        background: #a52d6b;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
</style>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Gallery image click
        $('.thumbnail-gallery img').click(function() {
            $('.main-image img').attr('src', $(this).attr('src'));
        });
        
        // Enrollment form submission
        $("#enrollForm").submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize();

            $(".text-danger").text(""); // Clear previous errors

            $.ajax({
                url: "{{ route('course.enroll') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'تم التسجيل بنجاح!',
                        text: 'سنتواصل معك خلال 24 ساعة لتأكيد الحجز.',
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
                            text: 'يرجى المحاولة مرة أخرى أو الاتصال بنا مباشرة.',
                            confirmButtonText: 'موافق'
                        });
                    }
                }
            });
        });
    });
</script>
@endsection