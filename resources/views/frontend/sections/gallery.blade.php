<section class="gallery-section py-5">
    <div class="container">
        <!-- العنوان -->
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-primary">
                <span class="text-secondary">استكشف</span> معرض الصور
            </h2>
        </div>

        <!-- أزرار التصنيفات -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex flex-wrap justify-content-center gap-2 filter-buttons">
                    <button class="btn btn-outline-primary active" data-filter="*">الكل</button>
                    @foreach ($categoriesgal->take(8) as $item)
                    <button class="btn btn-outline-primary" data-filter=".{{str_replace(' ', '-', $item->name)}}">
                        {{$item->name}}
                    </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- الصور -->
        <div class="row grid" data-isotope='{ "itemSelector": ".grid-item", "layoutMode": "masonry" }'>
            @foreach ($galleries as $item)
            <div class="col-lg-3 col-md-4 col-sm-6 grid-item {{str_replace(' ', '-', $item->category->name)}}">
                <div class="card h-100 shadow-sm overflow-hidden">
                    <a href="{{asset('uploads/'.$item->image)}}" data-fancybox="gallery">
                        <img 
                            src="{{asset('uploads/'.$item->image)}}" 
                            alt="{{$item->alt_text ?? 'صورة المعرض'}}" 
                            class="img-fluid card-img-top" 
                            loading="lazy"
                            style="height: 250px; object-fit: cover;"
                        >
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<style>
    .filter-buttons .btn {
        transition: all 0.3s ease;
        min-width: 120px;
        background: #e83e8c;
    }
    
    .filter-buttons .btn.active {
        background: rgb(151, 10, 151) !important;
        color: white !important;
        transform: scale(1.05);
    }
    
    .card {
        transition: transform 0.3s;
        border: none;
        border-radius: 12px;
    }
    
    .card:hover {
        transform: translateY(-5px);
    }
    
    .card-img {
        overflow: hidden;
        border-radius: 12px 12px 0 0;
    }
</style>
<script>
$(document).ready(function() {
    // تهيئة Isotope
    const $grid = $('.grid').isotope({
        itemSelector: '.grid-item',
        layoutMode: 'masonry',
        percentPosition: true
    });

    // تصفية الصور عند النقر على الأزرار
    $('.filter-buttons').on('click', 'button', function() {
        const filterValue = $(this).attr('data-filter');
        
        $('.filter-buttons button').removeClass('active');
        $(this).addClass('active');
        
        $grid.isotope({ filter: filterValue });
    });

    // تهيئة Fancybox
    $('[data-fancybox="gallery"]').fancybox({
        buttons: [
            "zoom",
            "share",
            "slideShow",
            "fullScreen",
            "close"
        ]
    });
});
</script>