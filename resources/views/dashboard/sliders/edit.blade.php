@extends('layouts.master')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('تعديل السلايدر') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('الرئيسية') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('sliders.index') }}">{{ __('السلايدرين') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('تعديل سلايدر') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section>
                <div class="card">
                    <div class="card-body">
                        @include('dashboard.inc.alerts')

                        <form action="{{ route('sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <!-- Image Upload -->
                            <div class="form-group">
                                <label for="image">الصورة</label>
                                <input type="file" class="form-control image" id="image" name="image" accept="image/*">
                                <div class="form-group">
                                    <img src="{{ asset('uploads/'.$slider->image) }}" style="width: 100px" class="img-thumbnail image-preview" alt="الصورة">
                                </div>
                                @error('image')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <!-- Row 1: Titles -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_title">العنوان العلوي</label>
                                        <input type="text" name="first_title" id="first_title" class="form-control" value="{{ old('first_title', $slider->first_title) }}">
                                        @error('first_title')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="secand_title">العنوان السفلي</label>
                                        <input type="text" name="secand_title" id="secand_title" class="form-control" value="{{ old('secand_title', $slider->secand_title) }}">
                                        @error('secand_title')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 2: Button -->
                            <div class="row">
                                <div class="col-md-6 mt-2">
                                    <label for="button_text">اسم الزر</label>
                                    <input type="text" class="form-control" name="button_text" value="{{ old('button_text', $slider->button_text) }}" id="button_text">
                                    @error('button_text')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="button_link">الرابط عند النقر على الزر</label>
                                    <input type="text" name="button_link" class="form-control" id="button_link" value="{{ old('button_link', $slider->button_link) }}">
                                    @error('button_link')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-success mt-3">{{ __('تحديث') }}</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
