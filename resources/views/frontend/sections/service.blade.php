<!-- قسم الخدمات -->
<section class="clearfix varietySection">
    <div class="container">
        <div class="secotionTitle">
            <h2><span>اكتشف</span> الخدمات</h2>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="tabbable tabTop">
                    <ul class="nav nav-tabs">
                        @foreach($categories as $category)
                            <li>
                                <a href="#{{ strtolower($category->name) }}" data-toggle="tab" class="{{ $loop->first ? 'active' : '' }}">
                                    <span>{{ $category->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach($categories as $category)
                            <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="{{ strtolower($category->name) }}">
                                <div class="tabbable tabs-left">
                                    <div class="row">
                                        <div class="col-md-5 col-lg-4">
                                            <ul class="nav nav-tabs">
                                                @foreach($category->services as $service)
                                                    <li>
                                                        <a href="javascript:void(0)" 
                                                           data-service-id="{{ $service->id }}" 
                                                           class="service-tab {{ $loop->first ? 'active' : '' }}">
                                                            {{ $service->title }} <span>${{ $service->price }}</span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="col-md-7 col-lg-8">
                                            <div class="tab-content">
                                                <div id="varietyContent">
                                                    @if($loop->first && $category->services->isNotEmpty())
                                                        @php
                                                            $firstService = $category->services->first();
                                                        @endphp
                                                        <img src="{{ asset('uploads/'.$firstService->image) }}" alt="{{ $firstService->title }}" class="img-responsive lazyestload">
                                                        <h3>{{ $firstService->title }}</h3>
                                                        <h4>${{ $firstService->price }} لكل شخص</h4>
                                                        <p>{{ $firstService->description }}</p>
                                                        <a href="javascript:void(0)" style="padding: 10px;border-radius: 5%;" 
                                                           class="btn btn-primary first-btn open-appointment-modal" 
                                                           data-toggle="modal" 
                                                           data-target="#appoinmentModal"
                                                           data-dss="aa"
                                                           data-service-title="{{ $firstService->title }}"
                                                           data-service-price="{{ $firstService->price }}">
                                                           احجز موعدًا
                                                        </a>
                                                    @else
                                                        <p>يرجى اختيار خدمة لعرض التفاصيل.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- نافذة الحجز -->
<div id="appoinmentModal" class="modal fade modalCommon" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title appointment-modal-title">حجز موعد لـ <span id="service-title"></span></h4>
            </div>
            <div class="modal-body">
                <form id="appoinmentModalForm">
                    @csrf
                    <div class="form-group categoryTitle">
                        <h5>تاريخ ووقت الخدمة</h5>
                    </div>
                    <div class="form-group">
                        <input type="datetime-local" name="appointment_date" class="form-control" placeholder="التاريخ" required>
                        <span class="text-danger error-appointment_date"></span> <!-- مكان الخطأ -->
                    </div>
                
                    <div class="form-group categoryTitle">
                        <h5>المعلومات الشخصية</h5>
                    </div>
                    <input type="hidden" name="service_id" id="service-id">
                    <span class="text-danger error-service_id"></span> <!-- مكان الخطأ -->
                
                    <div class="form-group">
                        <input type="text" name="full_name" class="form-control" placeholder="الاسم الكامل" required>
                        <span class="text-danger error-full_name"></span> <!-- مكان الخطأ -->
                    </div>
                    <div class="form-group">
                        <input type="text" name="id_number" class="form-control" placeholder="رقم الهوية " required>
                        <span class="text-danger error-id_number"></span> <!-- مكان الخطأ -->
                    </div>
                    <div class="form-group">
                        <input type="text" name="phone" class="form-control" placeholder="رقم الهاتف" required>
                        <span class="text-danger error-phone"></span> <!-- مكان الخطأ -->
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="address" placeholder="عنوانك" required></textarea>
                        <span class="text-danger error-address"></span> <!-- مكان الخطأ -->
                    </div>
                    <div class="form-group">
                        <button type="button" id="send_button" class="btn btn-primary">إرسال الآن</button>
                    </div>
                </form>
                
                
                
                
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.open-appointment-modal').on('click', function() {
            var serviceTitle = $(this).data('service-title');
            var servicePrice = $(this).data('service-price');
            
            $('#service-title').text(serviceTitle);
            $('.appointment-modal-title').text('حجز موعد لـ ' + serviceTitle);
        });
    });
</script>