<div class="row" id="productsContainer" data-last-page="{{ $products->lastPage() }}">
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
{{-- 
@if($products->hasMorePages())
    <div class="col-12 text-center mb-4">
        <button id="loadMoreBtn" class="btn btn-primary">تحميل المزيد</button>
    </div>
@endif --}}
<div class="col-12 mt-4">
    <div class="d-flex justify-content-center">
        {!! $products->withQueryString()->links('pagination::bootstrap-4') !!}
    </div>
</div>
