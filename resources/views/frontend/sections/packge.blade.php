<!-- PRICING SECTION -->
<section class="clearfix pricingSection patternbg">
    <div class="container">
        <div class="secotionTitle">
            <h2><span>الباقات </span>المذهلة</h2>
        </div>

        <div class="row">
            @foreach($packages as $package)
                <div class="col-md-6 col-lg-4">
                    <div class="priceTableWrapper">
                        <div class="priceImage">
                            <img src="{{ asset('uploads/'.$package->image) }}" data-src="{{ asset('uploads/'.$package->image) }}" alt="Image Price" class="img-responsive lazyestload">
                            <div class="maskImage">
                                <h3>{{ $package->name }}</h3>
                            </div>
                            <div class="priceTag">
                                <h4>${{ $package->price }}</h4>
                            </div>
                        </div>
                        <div class="priceInfo">
                            <ul class="list-unstyled">
                                @foreach(explode("\n", $package->description) as $feature)
                                    <li>{!! $feature !!}</li>
                                @endforeach
                            </ul>
                            <button class="btn btn-primary first-btn openModalBtn" style="padding: 10%; border-radius: 5%"
                                data-id="{{ $package->id }}"
                                data-name="{{ $package->name }}"
                                data-toggle="modal"
                                data-target="#PriceModal">
                              طلب اشتراك
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- بوابة الشراء -->
<div id="PriceModal" class="modal fade modalCommon" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title appointment-modal-title">شراء الباقة: <span id="package-title"></span></h4>
            </div>
            <div class="modal-body">
                <form id="PriceingForm">
                    @csrf
                    <input type="hidden" name="package_id" id="package-id">

                    <div class="form-group">
                        <label>الاسم الكامل</label>
                        <input type="text" name="full_name" class="form-control" placeholder="الاسم الكامل" required>
                        <span class="text-danger error-full_name"></span>
                    </div>
                    <div class="form-group">
                        <label>رقم الهوية</label>
                        <input type="text" name="id_number" class="form-control" placeholder="رقم الهوية" required>
                        <span class="text-danger error-id_number"></span>
                    </div>
                    <div class="form-group">
                        <label>رقم الهاتف</label>
                        <input type="text" name="phone" class="form-control" placeholder="رقم الهاتف" required>
                        <span class="text-danger error-phone"></span>
                    </div>
                    <div class="form-group">
                        <label>العنوان</label>
                        <textarea class="form-control" name="address" placeholder="عنوانك" required></textarea>
                        <span class="text-danger error-address"></span>
                    </div>
                    <div class="form-group text-center">
                        <button type="button" id="send_button_price" class="btn btn-primary">إرسال الطلب</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
