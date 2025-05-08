@extends('layouts.frontend')
@section('style')
    <style>
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

        .produtSingle {
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
            transition: transform 0.3s ease;
            /* height: 100%; */
            display: flex;
            flex-direction: column;
        }

        .produtSingle:hover {
            transform: translateY(-5px);
        }

        .produtImage {
            position: relative;
            overflow: hidden;
            height: 200px;
        }

        .produtImage img {
            width: 100%;
            object-fit: cover;
        }

        .productMask {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .produtSingle:hover .productMask {
            opacity: 1;
        }

        .productOption {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 10px;
        }

        .productOption li {
            display: inline-block;
        }

        .productOption a {
            color: #fff;
            font-size: 18px;
        }

        .productCaption {
            padding: 15px;
            text-align: center;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .productCaption h2 {
            font-size: 18px;
        }

        .productCaption h2 a {
            color: #333;
            text-decoration: none;
        }

        .productCaption h2 a:hover {
            color: #007bff;
        }

        .productCaption del {
            color: #6c757d;
        }

        .productCaption h2:last-child {
            color: #c415a6;
        }

        /* Loading spinner styles */
        #loadingSpinner {
            display: none;
            text-align: center;
            padding: 20px;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
    </style>
@endsection

@section('content')
    <section class="container-fluid clearfix productArea">
        <div class="container">
            <div class="secotionTitle mb-5">
                <h2><span>المنتجات </span>المميزة</h2>
            </div>
            <!-- Search Bar -->
            <div class="row mb-4">
                <div class="col-md-8 offset-md-2">
                    <form id="searchForm">
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control search-input"
                                placeholder="ابحث عن منتج..." aria-label="Search">
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

            <!-- Products Container -->
            <div id="ajaxContainer">
                @include('frontend.partials._products')
            </div>
            <div class="loading-spinner" id="loadingSpinner">
                <div class="spinner"></div>
                <p>جاري تحميل المزيد من المنتجات...</p>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <!-- Animate.css library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <script>
        $(document).ready(function() {
            let loading = false;
            let currentPage = 1;
            let lastPage = {{ $products->lastPage() }};
            let searchQuery = '';
            const $loadingSpinner = $('#loadingSpinner');

            // Function to fetch products
            function fetchProducts(page = 1, search = '', reset = false) {
                if (loading) return;

                loading = true;
                $loadingSpinner.show();

                $.ajax({
                    url: "{{ route('products') }}",
                    method: "GET",
                    data: {
                        page: page,
                        search: search
                    },
                    success: function(response) {
                        if (reset) {
                            $('#ajaxContainer').html(response);
                            currentPage = 1;
                            lastPage = parseInt($('#productsContainer').data('last-page'));
                        } else {
                            $('#ajaxContainer').append(response);
                        }

                        loading = false;
                        $loadingSpinner.hide();
                    },
                    error: function() {
                        loading = false;
                        $loadingSpinner.hide();
                        alert('حدث خطأ أثناء تحميل البيانات.');
                    }
                });
            }

            // Search functionality
            $('#searchInput').on('input', function() {
                searchQuery = $(this).val();
                fetchProducts(1, searchQuery, true);
            });

            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                searchQuery = $('#searchInput').val();
                fetchProducts(1, searchQuery, true);
            });

            // Infinite scroll
            $(window).scroll(function() {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200) {
                    if (currentPage < lastPage && !loading) {
                        currentPage++;
                        fetchProducts(currentPage, searchQuery);
                    }
                }
            });

            // Optional: Load more button click handler
            $(document).on('click', '#loadMoreBtn', function() {
                if (currentPage < lastPage && !loading) {
                    currentPage++;
                    fetchProducts(currentPage, searchQuery);
                }
            });
        });
    </script>
@endsection
