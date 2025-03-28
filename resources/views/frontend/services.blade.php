@extends('layouts.frontend')

@section('style')
<style>
    /* نفس ستايل كروت المنتجات مع تعديلات بسيطة */
    .serviceSingle {
        border: 1px solid #ddd;
        border-radius: 5px;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
        transform-style: preserve-3d;
    }
    
    /* Flip Animation (عند الضغط) */
    .serviceSingle.flipped {
        transform: rotateY(180deg);
    }
    
    .serviceImage {
        position: relative;
        overflow: hidden;
        height: 200px;
    }
    
    .serviceImage img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    
    .serviceMask {
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
    
    .serviceSingle:not(.flipped):hover .serviceMask {
        opacity: 1;
    }
    
    .serviceOption {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        gap: 10px;
    }
    
    .serviceOption li {
        display: inline-block;
    }
    
    .serviceOption a {
        color: #fff;
        font-size: 18px;
    }
    
    /* الوجه الأمامي */
    .serviceFront {
        backface-visibility: hidden;
        position: absolute;
        width: 100%;
        height: 100%;
    }
    
    /* الوجه الخلفي */
    .serviceBack {
        backface-visibility: hidden;
        position: absolute;
        width: 100%;
        height: 100%;
        background: #e83e8c;
        color: white;
        transform: rotateY(180deg);
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }
    
    .serviceCaption {
        padding: 15px;
        text-align: center;
    }
    
    .serviceCaption h3 {
        font-size: 18px;
        margin-bottom: 10px;
    }
    
    .whatsapp-btn {
        background-color: #25D366;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
        margin-top: 15px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    /* البحث والتنسيقات العامة */
    .search-section {
        margin-bottom: 30px;
    }
    
    .pagination-container {
        margin-top: 30px;
    }
</style>
@endsection

@section('content')
<section class="container-fluid clearfix">
    <div class="container">
        <!-- شريط البحث -->
        <div class="row search-section">
            <div class="col-md-6 offset-md-3">
                <form id="searchForm">
                    <div class="input-group">
                        <input type="text" id="serviceInput" class="form-control" placeholder="ابحث عن خدمة..." aria-label="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- الخدمات -->
            <div class="row"id="servicesContainer">
                @foreach ($services as $item)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card-container" onclick="openWhatsApp('{{ $item->title }}')">
                        <div class="card">
                            <!-- Front Face -->
                            <div class="card-face front">
                                <img  class="lazyestload" data-src="{{asset('uploads/' . $item->image) }}" src="{{ asset('uploads/' . $item->image) }}" alt="Service Image">
                                <div class="overlay">{{ $item->title }}</div>
                            </div>
                            <!-- Back Face -->
                            <div class="card-face back">
                                <p>{!! $item->description !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        <!-- الترقيم -->
        <div class="pagination-container productPagination" 
    @if($services->isEmpty()) 
        style="display:none;" 
    @endif>
    <nav aria-label="Page navigation">
        <div class="d-flex justify-content-center mt-4">
            {{ $services->links('pagination::bootstrap-5') }}
        </div>
    </nav>
</div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // Flip Card Function
    function toggleFlip(card) {
        card.classList.toggle('flipped');
    }
    
    // WhatsApp Function
    function openWhatsApp(event, serviceTitle) {
        event.stopPropagation(); // لمنع flip عند الضغط على الزر
        const phoneNumber = "+970592722789";
        const message = `مرحباً، أنا مهتم بالخدمة: ${serviceTitle}`;
        const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
        window.open(whatsappUrl, '_blank');
    }
    
    // البحث (مثل صفحة المنتجات)
 // البحث (مثل صفحة المنتجات)
$(document).ready(function() {
    $('#serviceInput').on('input', function() {
        let searchQuery = $(this).val();
        $.ajax({
            url: "{{ route('services') }}",
            method: "GET",
            data: { search: searchQuery },
            success: function(response) {
                const servicesContainer = $(response).find('#servicesContainer').html();
                $('#servicesContainer').html(servicesContainer);

                // Check if there are any services and hide pagination if empty
                if (servicesContainer.trim() === '') {
                    $('.pagination-container').hide();
                } else {
                    $('.pagination-container').show();
                }
            },
            error: function() {
                alert('حدث خطأ أثناء البحث.');
            }
        });
    });

    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
    });
});

</script>
@endsection