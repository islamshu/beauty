<div class="row" id="servicesContainer">
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

<div class="pagination-container d-flex justify-content-center mt-4">
    {{ $services->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>
