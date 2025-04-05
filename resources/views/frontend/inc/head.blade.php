<head>

    <!-- SITE TITTLE -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ get_general_value('website_name') }}</title>

    <!-- GOOGLE FONT -->
    <link
        href="https://fonts.googleapis.com/css2?family=Herr+Von+Muellerhoff&amp;family=Montserrat:wght@400;700&amp;family=Open+Sans:wght@300;400;600;700&amp;display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- PLUGINS CSS STYLE -->
    {{-- <link href="{{ asset('front/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('front/plugins/bootrtl.min.css') }}" rel="stylesheet" id="bootstrap-rtl">
    <link href="{{ asset('front/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/plugins/animate/animate.css" rel="stylesheet') }}">

    <link href="{{ asset('front/plugins/selectbox/select_option1.css') }}" rel='stylesheet'>
    <link href="{{ asset('front/plugins/owl-carousel/owl.carousel.min.css') }}" rel='stylesheet' media='screen'>

    <link href="{{ asset('front/plugins/isotope/isotope.min.css') }}" rel='stylesheet'>
    <link href="{{ asset('front/plugins/datepicker/datepicker.min.css') }}" rel='stylesheet'>
<!-- Fancybox CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0.1/dist/fancybox.css" />

<!-- Fancybox JS -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0.1/dist/fancybox.umd.js"></script>

    <!-- CUSTOM CSS -->
    <link href="{{ asset('front/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('front/css/rtl.css') }}" rel="stylesheet" id="rtl_css">

    <link href="{{ asset('front/css/default.css') }}" rel="stylesheet" id="option_color">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;600&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- green_color
    <link href="{{ asset('front/css/color-option1.css') }}" rel="stylesheet" id="option_color"> --}}
    {{-- pink color
    <link href="{{ asset('front/css/color-option2.css') }}" rel="stylesheet" id="option_color"> --}}


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Slick Slider CSS -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />

    <!-- FAVICON -->
    <link href="{{ asset('uploads/' . get_general_value('website_icon')) }}" rel="shortcut icon">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Tajawal', sans-serif;
        }

        .spinner-border {
            margin-left: 5px;
            vertical-align: middle;
        }

        .error-message {
            font-size: 0.85rem;
            margin-top: 5px;
        }

        #submitBtn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        /* تخصيص الخط على العناصر الأخرى */
        span,
        p,
        h1,
        h2,
        h3,
        ul,
        li {
            font-family: 'Tajawal', sans-serif !important;
        }

        .coursesSliderSection {
            padding: 60px 0;
            background-color: #f8f9fa;
        }

        .coursesSliderSection .secotionTitle h2 {
            font-size: 36px;
            font-weight: 700;
            color: #333;
            text-align: center;
            margin-bottom: 40px;
        }

        .coursesSliderSection .secotionTitle h2 span {
            color: #ff6f61;
        }

        .courseCard {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin: 0 15px;
            /* مسافة بين الكاردات */
        }

        .courseCard:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .courseImage img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .courseInfo {
            padding: 20px;
        }

        .courseInfo h3 {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }

        .courseInfo h4 {
            font-size: 20px;
            font-weight: 600;
            color: #ff6f61;
            margin-bottom: 15px;
        }

        .courseInfo p {
            font-size: 16px;
            color: #666;
            margin-bottom: 20px;
        }

        .courseInfo .btn {
            background-color: #ff6f61;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .courseInfo .btn:hover {
            background-color: #e65a50;
        }

        /* Paste this css to your style sheet file or under head tag */
        /* This only works with JavaScript,
    if it's not present, don't show loader */

        .no-js #loader {
            display: none;
        }

        .js #loader {
            display: block;
            position: absolute;
            left: 100px;
            top: 0;
        }

        .se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url({{ asset('front/plugins/simple-pre-loader/images/loader-64x/Preloader_2.gif') }}) center no-repeat #fff;
        }

        .two-lines {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* تحديد الحد الأقصى لعدد الأسطر */
            -webkit-box-orient: vertical;
            /* ضبط اتجاه المحتوى عمودي */
            overflow: hidden;
            /* إخفاء النص الزائد */
            text-overflow: ellipsis;
            /* إضافة ثلاث نقاط في النهاية إذا كان النص يتجاوز */
            white-space: normal;
            /* السماح بتفريغ النص إلى أسطر متعددة */
        }
    </style>

</head>
@yield('style')
