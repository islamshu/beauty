@extends('layouts.frontend')
@section('style')
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Tajawal', sans-serif;
        }

        .package-card {
            background: #d1b7a1;
            border-radius: 10px;
            overflow: hidden;
            text-align: center;
            padding: 15px;
            position: relative;
            transition: transform 0.3s ease-in-out;
            height: 100%;
            /* لجعل كل البطاقات بنفس الارتفاع */
            display: flex;
            flex-direction: column;
        }

        .package-card:hover {
            transform: scale(1.05);
        }

        .package-card img {
            width: 100%;
            height: 200px;
            /* ارتفاع ثابت لجميع الصور */
            border-radius: 5px;
            object-fit: cover;
            /* للحفاظ على تناسق الصورة */
            margin-bottom: 15px;
        }

        .package-title {
            font-size: 22px;
            font-weight: bold;
            color: #fff;
            background: #e83e8c;
            padding: 8px;
            border-radius: 5px;
            margin-top: 10px;
            margin-bottom: 15px;
        }

        .package-details {
            text-align: center;
            padding: 10px;
            flex-grow: 1;
            /* لملء المساحة المتبقية */
        }

        .package-details ul {
            padding: 0;
            margin-bottom: 20px;
        }

        .package-details li {
            font-size: 18px;
            /* حجم خط أكبر */
            font-weight: 500;
            /* سماكة الخط */
            color: #333;
            /* لون داكن لتحسين الوضوح */
            padding: 8px 0;
            /* تباعد بين العناصر */
            list-style-type: none;
            /* إزالة النقاط */
            border-bottom: 1px dashed #e83e8c;
            /* خط فاصل جميل */
        }

        .package-price {
            background: #706369;
            color: white;
            font-size: 14px;
            font-weight: bold;
            padding: 10px;
            border-radius: 5px;
            margin-top: auto;
            /* لدفع السعر إلى الأسفل */
        }

        .offer-banner {
            position: absolute;
            top: 20px;
            left: 50%;
            /* وضع البانر في منتصف العرض */
            transform: translateX(-50%);
            /* تعديل المركز بدقة */
            background: #e83e8c;
            color: white;
            padding: 5px 15px;
            font-size: 14px;
            border-radius: 5px;
            z-index: 1;
            white-space: nowrap;
            /* لمنع التفاف النص */
        }

        .subscribe-btn {
            background-color: #6c757d;
            /* لون أساسي */
            color: white;
            border: none;
            padding: 10px 25px;
            font-size: 18px;
            border-radius: 5px;
            margin-top: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: bold;
        }

        .subscribe-btn:hover {
            background-color: #5a6268;
            /* لون عند التحويم */
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* لون مختلف لكل زر حسب الباقة */
        .package-card:nth-child(1) .subscribe-btn {
            background-color: #e83e8c;
            /* وردي */
        }

        .package-card:nth-child(2) .subscribe-btn {
            background-color: #20c997;
            /* أخضر */
        }

        .package-card:nth-child(3) .subscribe-btn {
            background-color: #6f42c1;
            /* بنفسجي */
        }

        .visits-container {
            background-color: #f8f1e9;
            /* لون خلفية مختلف */
            border-radius: 8px;
            padding: 12px;
            margin: 15px 0;
            border: 1px dashed #e83e8c;
            /* حد منقط */
        }

        .visits-title {
            font-size: 16px;
            font-weight: bold;
            color: #6c757d;
            margin-bottom: 8px;
            text-align: center;
        }

        .visits-count {
            font-size: 24px;
            font-weight: bold;
            color: #e83e8c;
            text-align: center;
            display: block;
        }

        .visits-note {
            font-size: 12px;
            color: #6c757d;
            text-align: center;
            margin-top: 5px;
            font-style: italic;
        }

        .package-note-container {
            display: none;
            margin-bottom: 20px;
        }

        .package-note {
            border: 2px solid #f8d7da;
            padding: 15px;
            color: #721c24;
            background-color: #f8d7da;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection

@section('content')
    <section class="container-fluid clearfix productArea">
        <div class="container">
            <div class="secotionTitle mb-5">
                <h2><span>الباقات </span>المذهلة</h2>
            </div>
            <!-- Search Bar -->


            <!-- Products Container -->
            <div class="container py-5">
                <div class="row">
                    @foreach ($packages as $item)
                        <div class="col-md-4 mb-4">
                            <div class="package-card wow fadeInUp" data-wow-delay="0.2s">
                                @if ($item->number_of_users_type == 'limited')
                                    <span class="offer-banner">عرض خاص فقط لـ {{ $item->number_of_users }} مشتركة</span>
                                @endif
                                <img src="{{ asset('uploads/' . $item->image) }}" alt="{{ $item->name }}"
                                    class="img-fluid">
                                <div class="package-title">{{ $item->name }}</div>
                                <div class="package-details">
                                    <ul>
                                        @foreach ($item->services as $service)
                                            <li>{{ $service->title }}</li>
                                        @endforeach
                                    </ul>
                                    <div class="visits-container">
                                        <div class="visits-title">تشمل عدد الزيارات : <span
                                                style="    font-size: 23px;color: #e83e8c;">
                                                {{ $item->number_of_visits }} زيارات</Span></div>
                                    </div>
                                    <div class="package-price">{{ $item->price }} شيكل لمدة
                                        {{ format_package_duration($item->id) }} فقط</div>
                                    <button class="subscribe-btn"
                                        onclick="openSubscriptionModal('{{ $item->id }}', '{{ $item->name }}','{{ $item->note }}')">طلب
                                        اشتراك</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <div id="PriceModal" class="modal fade modalCommon" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title appointment-modal-title">شراء الباقة: <span id="package-title"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="modal-body" style="padding:0px">

                        <div id="package-note-container" class="package-note-container">
                            <p id="package-note" class="package-note"></p>
                        </div>
                        <form id="PriceingForm">
                            @csrf
                            <input type="hidden" name="package_id" id="package-id">

                            <div class="row">
                                <!-- الصف الأول - حقلين بجانب بعض -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>الاسم الكامل</label>
                                        <input type="text" name="full_name" class="form-control"
                                            placeholder="الاسم الكامل" required>
                                        <span class="text-danger error-full_name"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">


                                    <div class="form-group">
                                        <label for="phoneNumber">رقم الهاتف</label>
                                        <div class="input-group input-group-sm">
                                            <input type="tel" class="form-control" id="phoneNumber"
                                                placeholder="0590000000" name="phone" pattern="^0[0-9]{9}$"
                                                title="يجب أن يبدأ رقم الهاتف بـ 0 ويتكون من 10 أرقام" maxlength="10"
                                                required>
                                            <select class="form-control country-code-select" name="country_code"
                                                id="countryCode" style="max-width: 80px;" required>
                                                <option value="+970">970</option>
                                                <option value="+972">972</option>
                                            </select>
                                        </div>
                                        <span class="text-danger error-phone-combined"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- الصف الثاني - حقل العنوان كامل العرض -->

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>العنوان</label>
                                        <textarea class="form-control" name="address" placeholder="عنوانك" required></textarea>
                                        <span class="text-danger error-address"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- زر الإرسال -->
                            <div class="form-group text-center">
                                <button type="button" id="send_button_price" class="btn btn-primary">إرسال الطلب</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Animate.css library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <script>
        function openSubscriptionModal(packageId, packageName, note) {
            // تعبئة بيانات الباقة في المودال
            $('#package-id').val(packageId);
            $('#package-title').text(packageName);
            const noteContainer = $('#package-note-container');
            const noteElement = $('#package-note');

            if (note && note.trim() !== '') {
                noteElement.text(note);
                noteContainer.show(); // إظهار الحاوية إذا كانت هناك ملاحظات
            } else {
                noteContainer.hide(); // إخفاء الحاوية إذا لم تكن هناك ملاحظات
            }
            // فتح المودال
            $('#PriceModal').modal('show');
        }
        // تحديث الحقل المخفي عند تغيير رمز الدولة

        // التأكد من تعيين القيمة الافتراضية عند التحميل
        $(document).ready(function() {
            $('#country-code-hidden').val($('.country-code-select').val());
        });
    </script>
@endsection
