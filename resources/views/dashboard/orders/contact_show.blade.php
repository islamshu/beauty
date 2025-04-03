@extends('layouts.master')
@section('title', 'اتصل بنا')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('اتصل بنا') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('اتصل بنا') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <section>
                    <div class="card">
                        <div class="card-body">
                            <form id="contactForm">
                                <div class="row">
                                    <!-- الاسم -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ __('الاسم') }}</label>
                                            <input type="text" name="name" value="{{$contact->name}}" readonly id="name" class="form-control">
                                        </div>
                                    </div>

                                    <!-- البريد الإلكتروني -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">{{ __('البريد الإلكتروني') }}</label>
                                            <input type="email" value="{{$contact->email}}" readonly name="email" id="email" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- رقم الهاتف -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mobile">{{ __('رقم الهاتف') }}</label>
                                            <input type="text" value="{{$contact->phone}}" readonly name="mobile" id="mobile" class="form-control">
                                        </div>
                                    </div>

                                    
                                </div>

                                <!-- الرسالة -->
                                <div class="form-group">
                                    <label for="message">{{ __('رسالتك') }}</label>
                                    <textarea name="message" disabled id="message" class="form-control">{{$contact->message}}</textarea>
                                </div>

                                <!-- زر الإرسال (بدون وظيفة إرسال) -->
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('.select2').select2({
            placeholder: "{{ __('اختر الموضوع') }}",
            allowClear: true
        });
    });
</script>
@endsection
