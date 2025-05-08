@extends('layouts.master')
@section('title', 'الرسائل')
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('إعدادات الرسائل') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('messages.index') }}">{{ __('الرسائل') }}</a></li>

                            <li class="breadcrumb-item active">{{ __('إعدادات الرسائل') }}</li>
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
                                <h4 class="card-title">{{ __('إعدادات الرسائل') }}</h4>
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
                                    <form method="POST" action="{{ route('messages.update', $message->key) }}">
                                        @csrf
                                        @method('PUT')
                                
                                        <div class="form-group">
                                            <label for="content">نص الرسالة</label>
                                            <textarea name="content" id="content" rows="5" class="form-control">{{ old('content', $message->content) }}</textarea>
                                        </div>
                                
                                        <button type="submit" class="btn btn-primary mt-3">حفظ</button>
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