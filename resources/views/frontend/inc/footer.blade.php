
<footer class="patternbg" style="background-image: url({{asset('front/img/home/footer-bg.jpg')}});">
    <!-- BACK TO TOP BUTTON -->
    <a href="#pageTop" class="backToTop"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
    <!-- FOOTER INFO -->
    <div class="clearfix footerInfo">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-xs-12">
                    <div class="footerText">
                        <a href="/" class="footerLogo">
                           <img src="{{asset('uploads/'.get_general_value('website_logo'))}}" width="250"  alt="{{get_general_value('website_name')}}">
                        </a>
                        <p>{{get_general_value('description')}}</p>
                    </div>
                </div>
               
                <div class="col-md-8 order-md-1" style="top: 70px">
                    <ul class="list-inline socialLink" style="float:left; margin-left:0;">
                        <li><a href="javascript:void(0)"><i class="fa fa-twitter fa-2x" aria-hidden="true"></i></a></li>
                        <li><a href="javascript:void(0)"><i class="fa fa-linkedin fa-2x" aria-hidden="true"></i></a></li>
                        <li><a href="javascript:void(0)"><i class="fa fa-facebook fa-2x" aria-hidden="true"></i></a></li>
                        <li><a href="javascript:void(0)"><i class="fa fa-skype fa-2x" aria-hidden="true"></i></a></li>
                        <li><a href="javascript:void(0)"><i class="fa fa-pinterest-p fa-2x" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .socialLink {
            padding: 0;
            margin: 15px 0;
        }
        
        .socialLink li {
            display: inline-block;
            margin-right: 15px;
        }
        
        .socialLink li:last-child {
            margin-right: 0;
        }
        
        .socialLink a {
            color: #555;
            transition: all 0.3s ease;
        }
        
        .socialLink a:hover {
            color: #e83e8c; /* اللون عند التحويم */
            transform: scale(1.1);
        }
        
        .socialLink .fa {
            vertical-align: middle;
        }
    </style>
   
</footer>