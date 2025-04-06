<!-- PARTNER LOGO SECTION -->
<section class="clearfix brandArea patternbg">
    <div class="sectionTitle">
        <h2><span></span>شركائنا</h2>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="owl-carousel partnersLogoSlider">
                    @foreach ($partners as $item)
                    <div class="item">
                        <div class="partnersLogo">
                            <img src="{{ asset('uploads/'.$item->image) }}" 
                                 alt="{{ $item->title }}"
                                 class="img-fluid"
                                 title="{{ $item->title }}">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add this CSS in your <head> or style section -->
<style>
    .brandArea {
        padding: 60px 0;
        background-color: #f8f9fa;
    }
    
    .sectionTitle h2 {
        text-align: center;
        margin-bottom: 40px;
        color: #333;
        position: relative;
        font-size: 2rem;
    }
    
    .sectionTitle h2 span {
        display: block;
        width: 80px;
        height: 2px;
        background: #4e73df;
        margin: 15px auto;
    }
    
    .partnersLogo {
        text-align: center;
        padding: 15px;
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .partnersLogo img {
        max-width: 160px;
        max-height: 80px;
        width: auto;
        height: auto;
        filter: grayscale(100%);
        opacity: 0.7;
        transition: all 0.3s ease;
    }
    
    .partnersLogo:hover img {
        filter: grayscale(0);
        opacity: 1;
        transform: scale(1.05);
    }
    
    /* Owl Carousel fixes */
    .owl-carousel .owl-stage {
        display: flex;
        align-items: center;
    }
    
    .owl-item {
        display: flex;
        justify-content: center;
    }
</style>

<!-- Add this JavaScript at the end of your file -->
<script>
    $(document).ready(function(){
        // Initialize Owl Carousel
        $(".partnersLogoSlider").owlCarousel({
            loop: true,
            margin: 30,
            nav: false,
            dots: false,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 2
                },
                576: {
                    items: 3
                },
                768: {
                    items: 4
                },
                992: {
                    items: 5
                },
                1200: {
                    items: 6
                }
            }
        });
        
        // Fix for Owl Carousel lazy loading
        $('.partnersLogoSlider').on('initialized.owl.carousel', function() {
            $('.lazyestload').each(function() {
                $(this).attr('src', $(this).data('src'));
            });
        });
    });
</script>