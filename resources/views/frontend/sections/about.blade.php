   <!-- ABOUT SECTION -->
   <section class="container-fluid clearfix aboutSection patternbg ">
       <div class="aboutInner">
           <div class="sepcialContainer">
               <div class="row">
                   <div class="col-sm-3 col-xs-12 rightPadding">
                       <div class="imagebox ">
                           <img class="img-responsive lazyestload" data-src="{{ asset('uploads/' . $abouts->image) }}"
                               src="{{ asset('uploads/' . $abouts->image) }}" alt="Image About">
                       </div>
                   </div>
                   <div class="col-sm-9 col-xs-12">
                       <div class="aboutInfo">
                           <h2 style="text-align: center">{{ $abouts->title }}</h2>
                           {!! $abouts->descritpion !!}
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </section>
