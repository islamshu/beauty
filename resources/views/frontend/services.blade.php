@extends('layouts.frontend')

@section('style')
<style>
    .pagination {
        margin-bottom: 0;
    }
    
    .page-item .page-link {
        color: #0d6efd;
        border: 1px solid #dee2e6;
        padding: 8px 14px;
        margin: 0 3px;
        border-radius: 8px;
        transition: all 0.3s ease-in-out;
    }
    
    .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }
    
    .page-item.disabled .page-link {
        color: #aaa;
    }
    
    .page-link:hover {
        background-color: #f0f0f0;
        text-decoration: none;
    }

        .search-section {
            margin-bottom: 30px;
        }

        /* Search Input */
        .search-input {
            padding: 15px;
            font-size: 16px;
            border-radius: 25px;
            border: 1px solid #ccc;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }

        .search-input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        /* Search Button */
        .search-btn {
            background-color: #007bff;
            border-radius: 25px;
            border: none;
            padding: 14px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-btn i {
            font-size: 18px;
        }

        .search-btn:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        /* Responsive styling for search bar */
        @media (max-width: 768px) {
            .search-section .col-md-6 {
                max-width: 100%;
                padding: 0;
            }

            .search-input {
                font-size: 14px;
            }

            .search-btn {
                padding: 12px 18px;
                font-size: 14px;
            }
        }

        /* Flip Card Container */
        .flip-card {
            background-color: transparent;
            width: 100%;
            height: 300px;
            perspective: 1000px;
            /* تعطي تأثير العمق */
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
        .flip-card-front,
        .flip-card-back {
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

        /* شريط البحث */
        .search-section {
            margin-bottom: 30px;
        }

        /* زر عرض المزيد */
        .more-services {
            text-align: center;
            margin-top: 20px;
        }

        .more-services-btn {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .more-services-btn:hover {
            background-color: #0056b3;
        }

        .loading-spinner {
            display: none;
            text-align: center;
            padding: 20px;
        }

        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top: 4px solid #3498db;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
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
    
@endsection
@section('content')
    <section class="container-fluid varietySection mb-5">
        <div class="container">
            <div class="secotionTitle mb-5">
                <h2><span>الخدمات </span>المميزة</h2>
            </div>

            <!-- Search Bar -->
            <div class="row search-section">
                <div class="col-md-6 offset-md-3">
                    <form id="searchForm">
                        <div class="input-group">
                            <input type="text" id="serviceInput" class="form-control search-input"
                                placeholder="ابحث عن خدمة..." aria-label="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary search-btn"
                                    style="background-color: #e83e8c !important">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Services Container -->
            <div id="ajaxContainer">
                @include('frontend.partials._services')
            </div>

            <!-- Loading Spinner -->
            <div class="loading-spinner" id="loadingSpinner">
                <div class="spinner"></div>
                <p>جاري تحميل المزيد من الخدمات...</p>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        // WhatsApp Function
        function openWhatsApp(serviceName) {
            const phoneNumber = `{{ get_general_value('whatsapp_number') }}`;
            const message = `مرحباً، أنا مهتم بخدمة "${serviceName}"، هل يمكنكم تقديم المزيد من المعلومات؟`;
            const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
            window.open(whatsappUrl, '_blank');
        }

        // Infinite Scroll Implementation
    $(document).ready(function () {
        let currentPage = 1;
        let searchQuery = '';

        // Function to fetch services by AJAX
        function fetchServices(page = 1, search = '') {
            $.ajax({
                url: "{{ route('services') }}",
                method: "GET",
                data: {
                    page: page,
                    search: search
                },
                success: function (response) {
                    $('#ajaxContainer').html(response);
                    currentPage = page;
                },
                error: function () {
                    alert('حدث خطأ أثناء تحميل البيانات.');
                }
            });
        }

        // Search
        $('#serviceInput').on('input', function () {
            searchQuery = $(this).val();
            fetchServices(1, searchQuery);
        });

        $('#searchForm').on('submit', function (e) {
            e.preventDefault();
            searchQuery = $('#serviceInput').val();
            fetchServices(1, searchQuery);
        });

        // Pagination click event
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            const page = $(this).attr('href').split('page=')[1];
            fetchServices(page, searchQuery);
        });
    });

    </script>
@endsection
