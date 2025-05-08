<section class="clearfix varietySection">
    <div class="container">
        <div class="secotionTitle">
            <h2><span>الخدمات </span>المميزة</h2>
        </div>

        <div class="container mt-5">
            <div class="row">
                @foreach ($services as $item)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card-container">
                        <div class="flip-card">
                            <div class="flip-card-inner">
                                <!-- Front Face -->
                                <div class="flip-card-front">
                                    <img class="lazyestload" data-src="{{asset('uploads/' . $item->image) }}" 
                                         src="{{ asset('uploads/' . $item->image) }}" 
                                         alt="Service Image">
                                    <div class="overlay">{{ $item->title }}</div>
                                </div>
                                <!-- Back Face -->
                                <div class="flip-card-back">
                                    <p>{!! $item->description !!}</p>
                                    <button class="btn btn-warning book-service-btn" 
                                       onclick="openWhatsApp('{{ $item->title }}')">
                                       احجز الخدمة
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="more-services">
                <a href="{{route('services')}}" class="more-services-btn">المزيد من الخدمات</a>
            </div>
        </div>
    </div>
</section>

<script>
    function openWhatsApp(serviceName) {
        const phoneNumber = `{{ get_general_value('whatsapp_number')}}`;
        const message = `مرحباً، أنا مهتم بخدمة "${serviceName}"، هل يمكنكم تقديم المزيد من المعلومات؟`;
        const encodedMessage = encodeURIComponent(message);
        const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;
        window.open(whatsappUrl, '_blank');
    }
</script>

<style>
    /* Flip Card Container */
    .flip-card {
        background-color: transparent;
        width: 100%;
        height: 100px;
        perspective: 1000px; /* تعطي تأثير العمق */
    }

    /* Inner Flip Card */
    .flip-card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        text-align: center;
        transition: transform 0.6s;
        transform-style: preserve-3d;
    }

    /* عند التحويم تتحول البطاقة */
    .flip-card:hover .flip-card-inner {
        transform: rotateY(180deg);
    }

    /* وجه البطاقة الأمامي والخلفي */
    .flip-card-front, .flip-card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        border-radius: 10px;
        overflow: hidden;
    }

    /* الوجه الأمامي */
    .flip-card-front {
        background: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .flip-card-front img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .overlay {
        position: absolute;
        bottom: 0;
        width: 100%;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        padding: 10px;
        text-align: center;
        font-size: 18px;
        font-weight: bold;
    }

    /* الوجه الخلفي */
    .flip-card-back {
        background: #f8f9fa;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 20px;
        transform: rotateY(180deg);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .flip-card-back p {
        margin-bottom: 15px;
        font-size: 14px;
        text-align: center;
    }

    /* زر الحجز */
    .book-service-btn {
        padding: 8px 20px;
        font-size: 14px;
        background-color: #ffc107;
        border: none;
        border-radius: 4px;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .book-service-btn:hover {
        background-color: #e0a800;
        transform: translateY(-2px);
    }
</style>
