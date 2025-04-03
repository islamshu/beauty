<footer class="patternbg" style="background-image: url({{asset('front/img/home/footer-bg.jpg')}}); position: relative;">
    <!-- طبقة تظليل للصورة الخلفية لتحسين قراءة النص -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.6);"></div>
    
    <!-- BACK TO TOP BUTTON -->
    <a onclick="topFunction()"  class="backToTop"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
    
    <!-- FOOTER INFO -->
    <div class="clearfix footerInfo" style="position: relative; z-index: 1;">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <div class="footer-content" style="padding: 50px 0; text-align: center;">
                        <a  class="footerLogo">
                           <img src="{{asset('uploads/'.get_general_value('website_logo'))}}" width="250" style="filter: brightness(0) invert(1);" alt="{{get_general_value('website_name')}}">
                        </a>
                        <p style="color: #fff; font-size: 16px; line-height: 1.6; margin-top: 20px; max-width: 600px; margin-left: auto; margin-right: auto;">
                            {{get_general_value('description')}}
                        </p>
                    </div>
                </div>
                <!-- قسم السوشيال ميديا على اليسار -->
                @php
    $socialNetworks = [
        'facebook' => ['icon' => 'facebook', 'color' => '#4267B2', 'name' => 'Facebook'],
        'twitter' => ['icon' => 'twitter', 'color' => '#1DA1F2', 'name' => 'Twitter'],
        'instagram' => ['icon' => 'instagram', 'color' => '#E1306C', 'name' => 'Instagram'],
        'linkedin' => ['icon' => 'linkedin', 'color' => '#0077B5', 'name' => 'LinkedIn'],
        'youtube' => ['icon' => 'youtube', 'color' => '#FF0000', 'name' => 'YouTube'],
        'snapchat' => ['icon' => 'snapchat', 'color' => '#FFFC00', 'name' => 'Snapchat'],
        'tiktok' => ['icon' => 'music', 'color' => '#000000', 'name' => 'TikTok']
    ];
@endphp

@if(has_active_social_links())
<div class="col-md-4 col-sm-6">
    <div class="social-media-section" style="padding: 30px 0;">
        <h3 style="color: #fff; margin-bottom: 20px; font-weight: 600;">تابعنا على</h3>
        <ul class="social-links-list" style="list-style: none; padding: 0;">
            @foreach($socialNetworks as $key => $network)
                @if(get_social_value($key))
                <li style="margin-bottom: 15px;">
                    <a href="{{ get_social_value($key) }}" target="_blank" style="color: #fff; text-decoration: none; display: flex; align-items: center; transition: all 0.3s;">
                        <div class="social-icon" style="width: 40px; height: 40px; background: {{ $network['color'] }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                            <i class="fa fa-{{ $network['icon'] }}" aria-hidden="true"></i>
                        </div>
                        <span>{{ $network['name'] }}</span>
                    </a>
                </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
@endif
                
                <!-- قسم النص واللوجو في الوسط -->
             
            </div>
        </div>
    </div>
    
    <!-- حقوق النشر -->
    <div style="position: relative; z-index: 1; background-color: rgba(0, 0, 0, 0.8); padding: 15px 0; text-align: center;">
        <p style="color: #aaa; margin: 0; font-size: 14px;">
            &copy; {{ date('Y') }} {{get_general_value('website_name')}}. جميع الحقوق محفوظة.
        </p>
    </div>

    <style>
        /* تأثيرات التحويم على روابط السوشيال ميديا */
        .social-links-list a:hover {
            transform: translateX(5px);
            color: #e83e8c !important;
        }
        
        .social-links-list a:hover .social-icon {
            transform: scale(1.1);
        }
        
        /* زر العودة للأعلى */
        .backToTop {
            position: fixed;
            top: 80%;
            right: 20px;
            width: 40px;
            height: 40px;
            background: #e83e8c;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999;
            opacity: 0.7;
            transition: all 0.3s;
        }
        
        .backToTop:hover {
            opacity: 1;
            transform: translateY(-5px);
        }
        
        /* التأكد من أن النص قابل للقراءة على الصورة */
        .footerText p, .footer-content p {
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.8);
        }
    </style>
</footer>