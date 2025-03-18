<!-- MAIN SLIDER -->
        <section class="main-slider" data-loop="true" data-autoplay="true" data-interval="7000">
            <div class="inner">

               

                <!-- Slide Two -->
                @if (count($sliders) == 1)
                    @php
                        $sliders = array_merge($sliders->toArray(), $sliders->toArray());
                    @endphp
                @endif
                @foreach ($sliders as $item)
                    
                <div class="slide slideResize slide2" style="background-image: url({{asset('uploads/'.$item['image'])}});">
                    <div class="container">
                        <div class="slide-inner2 common-inner">
                            <span class="h1 from-bottom">{{$item['first_title']}}</span><br>
                            <span class="h4 from-bottom">{{$item['secand_title']}}</span><br>
                            @if ($item['button_text'] != null)
                                <a href="{{$item['button_link']}}" class="btn btn-primary first-btn waves-effect waves-light scale-up">{{$item['button_text']}}</a>
                                
                            @endif
                            
                        </div>
                    </div>
                </div>
                @endforeach
                

              

               

            </div>
        </section>