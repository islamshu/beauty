<!-- قسم معرض الصور -->
<section>
    <div class="clearfix homeGalleryTitle">
        <div class="container">
            <div class="secotionTitle">
                <h2><span>استكشف </span>معرض الصور</h2>
            </div>
        </div>
    </div>

    <div class="container-fluid clearfix homeGallery mt-5">
        <div class="row">
            <div class="col-xs-12">
                <div class="filter-container isotopeFilters">
                    <ul class="list-inline filter">
                        <li class="active"><a href="#" data-filter="*">جميع الصور</a></li>
                        {{-- التصنيفات --}}
                        @foreach ($categoriesgal as $item)
                        <li><a href="#" data-filter=".{{$item->name}}">{{$item->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="row isotopeContainer" id="container">
            @foreach ($galleries as $item)
            <div class="col-sm-3 isotopeSelector {{$item->category->name}}">
                <div class="card">
                    <div class="card-img">
                        <a href="{{asset('uploads/'.$item->image)}}" data-fancybox="images">

                        <img class="img-full lazyestload" width="500" data-src="{{asset('uploads/'.$item->image)}}" 
                             src="{{asset('uploads/'.$item->image)}}" alt="صورة من المعرض">
                            </a>
                       
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
