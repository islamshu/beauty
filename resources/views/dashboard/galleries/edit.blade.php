@extends('layouts.master')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('تعديل الصورة') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('galleries.index') }}">{{ __('معرض الصور') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('تعديل الصورة') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ __('تعديل الصورة') }}</h4>
                            </div>
                            @include('dashboard.inc.alerts')

                            <div class="card-content">
                                <div class="card-body">
                                    <form action="{{ route('galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group col-8">
                                            <label for="title">{{ __('العنوان') }}</label>
                                            <textarea name="title" id="title" class=" ckeditor form-control" rows="4" required>{{$gallery->title}}</textarea>
                                        </div>
                                        <div class="form-group col-8">
                                            <label for="description">{{ __('الوصف') }}</label>
                                            <textarea name="description" id="description" class="ckeditor form-control" rows="4" required>{{$gallery->description}}</textarea>
                                        </div>
                                        <div class="form-group col-8">
                                            <label for="image">{{ __('الصورة') }}</label>
                                            <input type="file" name="image" id="image" class="form-control">
                                            <p>{{ __('الصورة الحالية:') }}</p>
                                            <img src="{{ asset('uploads/' . $gallery->image) }}" width="100">
                                        </div>
                                        <button type="submit" class="btn btn-success">{{ __('تحديث') }}</button>
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
