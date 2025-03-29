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
            <div class="col-md-6 offset-md-3">
                <form id="searchForm">
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control" placeholder="ابحث عن منتج..." aria-label="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- عرض المنتجات -->
        <div class="row" id="productsContainer">
            @foreach ($products as $product)
            <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                <div class="produtSingle">
                    <div class="produtImage">
                        <img src="{{ asset('uploads/' . $product->image) }}" data-src="{{ asset('uploads/' . $product->image) }}" alt="{{ $product->title }}" class="img-responsive lazyestload">
                        <div class="productMask">
                            <ul class="list-inline productOption">
                               
                                <li>
                                    <a href="{{ route('cart.add', $product->id) }}">
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    </a>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                    <div class="productCaption">
                        <h2><a href="{{ route('product.details', $product->id) }}">{{ $product->title }}</a></h2>
                        
                        <!-- السعر قبل الخصم -->
                        @if ($product->price_before_discount > $product->price_after_discount)
                            <del class="text-muted" style="text-decoration: line-through;">${{ $product->price_before_discount }}</del>
                        @endif
                        
                        <!-- السعر بعد الخصم -->
                        <h2>₪{{ $product->price_after_discount }}</h2>
                    </div>
                </div>
            </div>
        @endforeach
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

<script>
    
    $(document).ready(function () {
        // البحث في الوقت الفعلي
        $('#searchInput').on('input', function () {
            let searchQuery = $(this).val();

            $.ajax({
                url: "{{ route('products') }}",
                method: "GET",
                data: {
                    search: searchQuery,
                },
                success: function (response) {
                    $('#productsContainer').html($(response).find('#productsContainer').html());
                },
                error: function () {
                    alert('حدث خطأ أثناء البحث.');
                }
            });
        });

        // منع إعادة تحميل الصفحة عند إرسال النموذج
        $('#searchForm').on('submit', function (e) {
            e.preventDefault();
        });
    });
</script>
@endsection