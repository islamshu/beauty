@extends('layouts.master')
@section('title','اضافة خدمة')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('إضافة خدمة جديدة') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('الرئيسية') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('services.index') }}">{{ __('الخدمات') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('إضافة خدمة') }}</li>
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

                        <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row">
                                <!-- صورة الخدمة -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">{{ __('الصورة') }}</label>
                                        <input type="file" class="form-control image" id="image" name="image" accept="image/*">
                                        <div class="mt-2">
                                            <img src="" style="width: 100px" class="img-thumbnail image-preview" alt="الصورة">
                                        </div>
                                        @error('image')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- عنوان الخدمة -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">{{ __('عنوان الخدمة') }} <span class="required">*</span></label>
                                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                                        @error('title')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- الوصف (يأخذ العرض بالكامل) -->
                            

                            <div class="row">
                                <!-- سعر الخدمة -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price">{{ __('السعر') }} <span class="required">*</span></label>
                                        <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}" required>
                                        @error('price')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- اختيار الفئة -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category_id">{{ __('الفئة') }} <span class="required">*</span></label>
                                        <select name="category_id" id="category_id" class="form-control" required>
                                            <option value="" disabled selected>{{ __('اختر الفئة') }}</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="editor">الوصف <span class="required">*</span></label>
                                <textarea name="description" id="editor" class="form-control" required>{{ old('description') }}</textarea>
                                <small id="editor-error" class="text-danger" style="display: none;">هذا الحقل مطلوب!</small>
                            </div>
                            

                            <!-- زر الحفظ -->
                            <button type="submit" class="btn btn-success">{{ __('حفظ الخدمة') }}</button>
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
        // عرض معاينة للصورة المختارة
        $('#image').change(function () {
            let reader = new FileReader();
            reader.onload = function (e) {
                $('.image-preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });
</script>
@endsection