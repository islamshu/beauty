<div class="row" id="servicesContainer" data-last-page="{{ $services->lastPage() }}">
    @forelse ($services as $item)
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card-container">
                <div class="flip-card">
                    <div class="flip-card-inner">
                        <!-- Front Face -->
                        <div class="flip-card-front">
                            <img src="{{ asset('uploads/' . $item->image) }}" alt="{{ $item->title }}">
                            <div class="overlay">{{ $item->title }}</div>
                        </div>
                        <!-- Back Face -->
                        <div class="flip-card-back">
                            <p>{!! Str::limit($item->description, 100) !!}</p>
                            <button class="book-service-btn" onclick="openWhatsApp('{{ $item->title }}')">
                                احجز الخدمة
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center">
            <h5>لا توجد خدمات مطابقة</h5>
        </div>
    @endforelse
</div>

{{-- @if($services->hasMorePages())
    <div class="col-12 text-center mb-4">
        <button id="loadMoreBtn" class="btn btn-primary">تحميل المزيد</button>
    </div>
@endif --}}