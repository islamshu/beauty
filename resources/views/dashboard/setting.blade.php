@extends('layouts.master')
@section('title', 'اعدادات الموقع')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('إعدادات الموقع') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('إعدادات الموقع') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <section id="validation">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ __('إعدادات الموقع') }}</h4>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form" action="{{ route('add_general') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <!-- شعار الموقع -->
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label>{{ __('شعار الموقع') }}</label>
                                                        <input type="file" class="form-control border-primary imagee"
                                                            name="general_file[website_logo]">
                                                        <div class="form-group">
                                                            <img src="{{ asset('uploads/' . get_general_value('website_logo')) }}"
                                                                style="width: 100px" class="img-thumbnail image-previeww"
                                                                alt="">
                                                        </div>
                                                    </div>

                                                    <!-- أيقونة الموقع -->
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label>{{ __('أيقونة الموقع') }}</label>
                                                        <input type="file" class="form-control border-primary image"
                                                            name="general_file[website_icon]">
                                                        <div class="form-group">
                                                            <img src="{{ asset('uploads/' . get_general_value('website_icon')) }}"
                                                                style="width: 100px" class="img-thumbnail image-preview"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- اسم الموقع -->
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label>{{ __('اسم الموقع') }}</label>
                                                        <input type="text"
                                                            value="{{ get_general_value('website_name') }}" required
                                                            class="form-control border-primary" name="general[website_name]"
                                                            placeholder="{{ __('اسم الموقع') }}">
                                                    </div>


                                                    <!-- البريد الإلكتروني -->
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label>{{ __('البريد الإلكتروني') }}</label>
                                                        <input type="email"
                                                            value="{{ get_general_value('website_email') }}"
                                                            class="form-control border-primary"
                                                            name="general[website_email]"
                                                            placeholder="{{ __('البريد الإلكتروني') }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <!-- اسم الموقع -->
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label>{{ __('وصف الموقع ') }}</label>
                                                        <textarea name="general[description]" class="form-control border-primary" id="" cols="10"
                                                            placeholder="وصف الموقع" rows="5">{{ get_general_value('description') }}</textarea>
                                                    </div>
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label>{{ __('عنوان المركز') }}</label>
                                                        <textarea name="general[address]" class="form-control border-primary" id="" cols="10"
                                                            placeholder="عنوان المركز" rows="5">{{ get_general_value('address') }}</textarea>
                                                    </div>

                                                    <!-- البريد الإلكتروني -->

                                                </div>

                                                <div class="row">
                                                    <!-- رقم واتساب -->
                                                    <div class="form-group">
                                                        <label for="phoneNumber">رقم الهاتف</label>
                                                        <div class="input-group input-group-sm">
                                                            <input type="tel" class="form-control" id="phoneNumber"
                                                                placeholder="592412365" value="{{get_general_value('whataspp')}}" name="general[whataspp]" pattern="[0-9]{9}"
                                                                title="يجب إدخال 9 أرقام بالضبط" maxlength="9" required>
                                                            <select class="custom-select" name="general[country_code]" id="countryCode"
                                                                style="max-width: 80px;">
                                                                <option value="+970" @if(get_general_value('country_code') == '+970') selected @endif>970+</option>
                                                                <option value="+972"  @if(get_general_value('country_code') == '+972') selected @endif>972+</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>




                                            </div>

                                            <!-- زر الحفظ -->
                                            <div class="form-actions right">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> {{ __('حفظ التغييرات') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
