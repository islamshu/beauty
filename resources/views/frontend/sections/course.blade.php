<section id="courses" class="courses-section py-5">
    <div class="container">
        <!-- Section Header -->
        <div class="section-header text-center mb-5">
            <h2 class="section-title position-relative d-inline-block">
                <span class="highlight-text">اكتشف</span> دوراتنا التدريبية
            </h2>
            <p class="section-subtitle text-muted mt-3">اختر الدورة التي تناسب احتياجاتك وابدأ رحلة التعلم</p>
        </div>

        <!-- Courses Carousel -->
        <div id="courseCarousel" class="carousel carouselcour slide mt-5" data-ride="carousel">
            <!-- Slides -->
            <div class="carousel-inner">
                @php
                    function isMobile()
                    {
                        return preg_match(
                            '/(android|webos|avantgo|iphone|ipad|ipod|blackberry|iemobile|bolt|boost|cricket|docomo|fone|hiptop|mini|opera mini|kitkat|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i',
                            $_SERVER['HTTP_USER_AGENT'],
                        );
                    }

                    $itemsPerSlide = isMobile() ? 1 : 3;
                @endphp

                @foreach ($courses->chunk($itemsPerSlide) as $chunk)
                    <div class="carousel-item carousel-item-course  {{ $loop->first ? 'active' : '' }}">
                        <div class="row">
                            @foreach ($chunk as $item)
                                <div class="col-12 col-sm-6 col-md-4 col-lg-4 mb-4">
                                    <div class="course-card">
                                        <!-- Course Image with Price Badge -->
                                        <div class="course-thumbnail">
                                            <img src="{{ asset('uploads/' . $item->image) }}" alt="{{ $item->title }}"
                                                class="img-fluid">
                                            @if ($item->show_price)
                                                <div class="price-badge">
                                                    <span class="price-currency">₪</span>
                                                    <span class="price-amount">{{ number_format($item->price) }}</span>
                                                    @if ($item->installment_available)
                                                        <span class="price-installment">أو
                                                            {{ number_format($item->price / 3) }} ₪ × 3</span>
                                                    @endif
                                                </div>
                                            @endif
                                            <div class="course-overlay">
                                                <a href="{{ route('single_course', $item->id) }}"
                                                    class="btn btn-outline-light btn-sm">عرض التفاصيل</a>
                                            </div>
                                        </div>

                                        <!-- Course Info -->
                                        <div class="course-body">
                                            <h3 class="course-title text-center">{{ $item->title }}</h3>
                                            <p class="course-description">{!! $item->shortDescription(45) !!}</p>
                                            <a href="{{ route('single_course', $item->id) }}"
                                                class="btn btn-primary btn-block mt-3">
                                                <i class="fas fa-eye mr-2"></i> عرض الدورة
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Navigation -->
            <a class="carousel-control-prev" href="#courseCarousel" role="button" data-slide="prev">

                <span class="angle-right"><i class="fa fa-angle-left" aria-hidden="true"></i>
                </span>
                <span class="sr-only">السابق</span>
            </a>
            <a class="carousel-control-next" href="#courseCarousel" role="button" data-slide="next">
                <span class="angle-left"><i class="fa fa-angle-right" aria-hidden="true"></i>
                </span>
                <span class="sr-only">التالي</span>
            </a>

            <!-- Pagination indicators -->
            <ol class="carousel-indicators">
                @foreach ($courses->chunk($itemsPerSlide) as $index => $chunk)
                    <li data-target="#courseCarousel" data-slide-to="{{ $index }}"
                        class="{{ $loop->first ? 'active' : '' }}"></li>
                @endforeach
            </ol>
        </div>
    </div>
</section>

<style>
    /* تصميم مخصص لقسم الدورات */
    .courses-section {
        background-color: #f8f9fa;
        position: relative;
        overflow: hidden;
    }

    .section-header {
        position: relative;
    }

    .section-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: #2c3e50;
    }

    .highlight-text {
        color: #d63384;
        position: relative;
    }

    .highlight-text:after {
        content: '';
        position: absolute;
        bottom: 5px;
        right: 0;
        width: 100%;
        height: 8px;
        background-color: rgba(214, 51, 132, 0.2);
        z-index: -1;
    }

    .section-subtitle {
        font-size: 1.1rem;
    }

    /* بطاقة الدورة */
    .course-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    /* صورة الدورة */
    .course-thumbnail {
        position: relative;
        overflow: hidden;
    }

    .course-thumbnail img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .course-card:hover .course-thumbnail img {
        transform: scale(1.05);
    }

    /* سعر الدورة */
    .price-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(214, 51, 132, 0.9);
        color: white;
        padding: 8px 25px;
        border-radius: 5px;
        font-weight: bold;
        display: flex;
        flex-direction: column;
        align-items: center;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    .price-currency {
        font-size: 0.9rem;
    }

    .price-amount {
        font-size: 1.4rem;
        line-height: 1;
    }

    .price-installment {
        font-size: 0.7rem;
        margin-top: 3px;
        opacity: 0.9;
    }

    /* طبقة التغطية عند التحويم */
    .course-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .course-card:hover .course-overlay {
        opacity: 1;
    }

    /* محتوى البطاقة */
    .course-body {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .course-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: #2c3e50;
    }

    .course-description {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 15px;
        flex-grow: 1;
    }

    /* عناصر التحكم في السلايدر */
    .carousel-control-prev,
    .carousel-control-next {
        width: 40px;
        height: 40px;
        background-color: #d63384;
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        opacity: 1;
    }

    .carousel-control-prev {
        right: -20px;
        left: auto;
    }

    .carousel-control-next {
        left: -20px;
        right: auto;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        width: auto;
        height: auto;
        color: white;
        font-size: 1.2rem;
    }

    /* النقاط الدالة */
    .carousel-indicators {
        bottom: -50px;
    }

    .carousel-indicators li {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: #ced4da;
        margin: 0 5px;
    }

    .carousel-indicators .active {
        background-color: #d63384;
    }

    @media (max-width: 767.98px) {
        .course-card {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.8rem;
        }

        .col-12 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        @media (max-width: 576px) {
            .carousel-item-course {
                height: 58vh !important;
            }
        }
    }
</style>

<script>
    // تأكد من عمل السلايدر بشكل صحيح على جميع الأجهزة
    document.addEventListener('DOMContentLoaded', function() {
        const carousel = $('#courseCarousel');

        // إعادة حساب المؤشرات عند تغيير حجم الشاشة
        $(window).resize(function() {
            carousel.carousel('pause');
        });
    });
</script>
