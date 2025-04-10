<div id="imageSlider" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators" style="bottom: 0px; !important">
        @foreach ($sliders as $key => $item)
            <li data-target="#imageSlider" data-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"></li>
        @endforeach
    </ol>
    
    <!-- Slides -->
    <div class="carousel-inner">
        @foreach ($sliders as $key => $item)   
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                <div class="carousel-image-container">
                    <a @if($item->button_link != null  &&  $item->button_link != '#') href="{{ $item->button_link }} @endif"><img src="{{ asset('uploads/'.$item->image) }}" alt="{{ $item->first_title ?? 'Slide' }}" class="carousel-image"></a>
                </div>
            
            </div>
        @endforeach
    </div>
    
    <!-- Controls -->
    <a class="carousel-control-prev" href="#imageSlider" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#imageSlider" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<style>
    /* Base Carousel Styles */
    .carousel {
        width: 100%;
        overflow: hidden;
    }
    
    .carousel-item {
        position: relative;
        height: 60vh; /* Default height for larger screens */
        min-height: 300px; /* Minimum height */
    }
    
    /* Image Container */
    .carousel-image-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }
    
    .carousel-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }
    
    /* Caption Styling */
    .carousel-caption {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 20px;
    }
    
    .caption-content {
        background: rgba(198, 194, 194, 0.7);
        backdrop-filter: blur(5px);
        border-radius: 10px;
        padding: 25px;
        max-width: 800px;
        width: 90%;
        color: #333;
    }
    
    .carousel-caption h3 {
        font-size: clamp(1.5rem, 3vw, 2.5rem);
        margin-bottom: 15px;
        font-weight: bold;
    }
    
    .carousel-caption p {
        font-size: clamp(1rem, 1.8vw, 1.3rem);
        margin-bottom: 20px;
    }
    
    .carousel-caption .btn {
        font-size: clamp(0.9rem, 1.5vw, 1.1rem);
        padding: 8px 20px;
    }
    
    /* Responsive Adjustments */
   
    

    
</style>