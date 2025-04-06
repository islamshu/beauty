@extends('layouts.frontend')
@section('style')
<style>
    .produtSingle {
        border: 1px solid #ddd;
        border-radius: 5px;
        overflow: hidden;
        transition: transform 0.3s ease;
        height: 100%; /* تأكد من أن العنصر يأخذ الارتفاع الكامل */
        display: flex;
        flex-direction: column;
    }
    .produtSingle:hover {
        transform: translateY(-5px);
    }
    .produtImage {
        position: relative;
        overflow: hidden;
        height: 200px; /* ارتفاع ثابت للصورة */
    }
    .produtImage img {
        width: 100%;
        object-fit: cover; /* تأكد من أن الصورة تغطي المساحة المحددة */
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
        flex-grow: 1; /* تأكد من أن النص يملأ المساحة المتبقية */
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
        color: #6c757d; /* لون رمادي للسعر القديم */
    }
    .productCaption h2:last-child {
        color: #c415a6; /* لون أخضر للسعر الجديد */
    }
</style>
@endsection
@section('content')
<section class="container-fluid clearfix productArea">
    <div class="container">
        <!-- حقل البحث -->
        <div class="row mb-4">
            <div class="col-md-8 offset-md-2">
                <form id="searchForm">
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control search-input" placeholder="ابحث عن خدمة..." aria-label="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary search-btn" style="background-color: #e83e8c !important">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <div class="text-center my-4" id="loadingSpinner" style="display: none;">
                    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">looding </span>
                    </div>
                </div>
                
            </div>
        </div>
        
        <style>
            /* Search Bar Container */
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
        </style>

        <!-- عرض المنتجات -->
        <div class="row" id="productsContainer">
            @if ($products->count())
                @foreach ($products as $product)
                    <div class="col-md-6 col-lg-4 col-xl-3 mb-4 product-item animate__animated animate__fadeIn">
                        <div class="produtSingle">
                            <div class="produtImage">
                                <img src="{{ asset('uploads/' . $product->image) }}" alt="{{ $product->title }}" class="img-fluid">
                                <div class="productMask">
                                    <ul class="list-inline productOption">
                                        <li>
                                            <a href="{{ route('cart.add', $product->id) }}">
                                                <i class="fas fa-shopping-cart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="productCaption">
                                <h2 style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <a href="{{ route('product.details', $product->id) }}">{{ $product->title }}</a>
                                </h2>
                                <h2 class="price"><small>₪</small> {{ $product->price_after_discount }}</h2>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center py-5 animate__animated animate__fadeIn">
                    <h4 class="text-muted">لا توجد نتائج مطابقة لبحثك.</h4>
                </div>
            @endif
        </div>
        

        <!-- الترقيم -->
        <div class="paginationCommon productPagination">
            <nav aria-label="Page navigation">
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
                
            </nav>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<!-- مكتبة animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<script>
    $(document).ready(function () {
        const $searchInput = $('#searchInput');
        const $productsContainer = $('#productsContainer');
        const $spinner = $('#loadingSpinner');

        function fetchProducts(query) {
            $spinner.show(); // أظهر السبينر
            $.ajax({
                url: "{{ route('products') }}",
                method: "GET",
                data: { search: query },
                success: function (response) {
                    const newContent = $(response).find('#productsContainer').html();
                    $productsContainer.html(newContent);
                    $spinner.hide(); // أخفِ السبينر
                },
                error: function () {
                    $spinner.hide();
                    alert('حدث خطأ أثناء البحث.');
                }
            });
        }

        // البحث المباشر
        $searchInput.on('input', function () {
            let query = $(this).val();
            fetchProducts(query);
        });

        // منع إعادة تحميل الصفحة عند إرسال النموذج
        $('#searchForm').on('submit', function (e) {
            e.preventDefault();
        });
    });
</script>
@endsection
