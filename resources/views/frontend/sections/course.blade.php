<section id="courses" class="clearfix coursesSliderSection patternbg">
    <div class="container">
        <div class="secotionTitle">
            <h2><span>اكتشف</span> دوراتنا</h2>
        </div>

        <div id="coursesCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @foreach ($courses->chunk(3) as $chunk) <!-- Group items in chunks of 3 -->
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="row">
                            @foreach ($chunk as $item)
                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 mb-4"> <!-- Responsive layout -->
                                    <div class="courseCard" style="margin: 0 !important; text-align: center">
                                        <div class="courseImage">
                                            <img src="{{ asset('uploads/' . $item->image) }}" alt="{{ $item->title }}" class="img-fluid">
                                        </div>
                                        <div class="courseInfo">
                                            <h3>{{ $item->title }}</h3>
                                            @if($item->show_price)
                                                <h4>₪{{ $item->price }}</h4>
                                            @endif
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

            <!-- Navigation arrows -->
            <a class="carousel-control-prev" href="#coursesCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">السابق</span>
            </a>
            <a class="carousel-control-next" href="#coursesCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">التالي</span>
            </a>

            <!-- Pagination bullets -->
            <ol class="carousel-indicators">
                @foreach ($courses->chunk(3) as $index => $chunk) <!-- Matching chunk size -->
                    <li data-target="#coursesCarousel" data-slide-to="{{ $index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                @endforeach
            </ol>
        </div>
    </div>
</section>
