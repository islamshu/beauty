<section id="courses" class="clearfix coursesSliderSection patternbg">
    <div class="container">
        <div class="secotionTitle">
            <h2><span>اكتشف</span> دوراتنا</h2>
        </div>

        <div id="coursesCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @foreach ($courses->chunk(4) as $chunk)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="row">
                            @foreach ($chunk as $item)
                                <div class="col-12 col-sm-6 col-md-4 col-lg-4 mb-4">
                                    <div class="courseCard" style="margin: 0 !important">
                                        <div class="courseImage">
                                            <img src="{{ asset('uploads/' . $item->image) }}" alt="{{ $item->title }}" class="img-fluid">
                                        </div>
                                        <div class="courseInfo">
                                            <h3>{{ $item->title }}</h3>
                                            <h4>${{ $item->price }}</h4>
                                            <p class="two-lines">{!! \Illuminate\Support\Str::limit(strip_tags($item->description), 200) !!}</p>
                                            <a class="btn btn-info" href="{{ route('single_course', $item->id) }}">مشاهدة</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#coursesCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">السابق</span>
            </a>
            <a class="carousel-control-next" href="#coursesCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">التالي</span>
            </a>
        </div>
    </div>
</section>