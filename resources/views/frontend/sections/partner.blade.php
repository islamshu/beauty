 <!-- PARTNER LOGO SECTION -->
 <section class="clearfix brandArea patternbg">
    <div class="secotionTitle">
        <h2><span>  </span>شركائنا </h2>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="owl-carousel partnersLogoSlider">
                    @foreach ($partenrs as $item)
                        
                    <div class="slide">
                        <div class="partnersLogo clearfix">
                            <img class="lazyestload" title="{{$item->title}}" data-src="{{asset('uploads/'.$item->image)}}" src="{{asset('uploads/'.$item->image)}}" alt="Image Partner">
                        </div>
                    </div>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
</section>