@extends('layouts.master')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('إعدادات بوت التلجرام') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('إعدادات بوت التلجرام') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="telegram-settings">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ __('إعدادات بوت التلجرام') }}</h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collpase show">
                                    <div class="card-body">
                                        <form class="form" action="{{ route('add_general') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label for="api_key">{{ __('API Key') }}</label>
                                                        <input type="text" id="api_key"
                                                            class="form-control border-primary"
                                                            placeholder="{{ __('أدخل مفتاح API') }}"
                                                            name="general[api_key]"
                                                            value="{{ get_general_value('api_key') }}" required>
                                                    </div>
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label for="chat_id">{{ __('Chat ID') }}</label>
                                                        <input type="text" id="chat_id"
                                                            class="form-control border-primary"
                                                            placeholder="{{ __('أدخل معرف المحادثة') }}"
                                                            name="general[chat_id]"
                                                            value="{{ get_general_value('chat_id') }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions right">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> {{ __('حفظ') }}
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
