@extends('layouts.master')
@section('title','تعديل المنتج')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('تعديل المنتج') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('الرئيسية') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ __('المنتجات') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('تعديل المنتج') }}</li>
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

                        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <!-- صورة المنتج -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">{{ __('الصورة') }}</label>
                                        <input type="file" class="form-control image" id="image" name="image" accept="image/*">
                                        <div class="mt-2">
                                            <img src="{{ asset('uploads/' . $product->image) }}" style="width: 100px" class="img-thumbnail image-preview" alt="الصورة">
                                        </div>
                                        @error('image')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- عنوان المنتج -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">{{ __('عنوان المنتج') }} <span class="required">*</span></label>
                                        <input type="text" name="title" id="title" class="form-control" value="{{ $product->title }}" required>
                                        @error('title')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- سعر المنتج بعد الخصم -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price_after_discount">{{ __('السعر بعد الخصم') }} <span class="required">*</span></label>
                                        <input type="number" name="price_after_discount" id="price_after_discount" class="form-control" value="{{ $product->price_after_discount }}" required>
                                        @error('price_after_discount')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- سعر المنتج قبل الخصم -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price_before_discount">{{ __('السعر قبل الخصم') }} <span class="required">*</span></label>
                                        <input type="number" name="price_before_discount" id="price_before_discount" class="form-control" value="{{ $product->price_before_discount }}" required>
                                        @error('price_before_discount')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- الوصف المختصر -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="small_description">{{ __('الوصف المختصر') }} <span class="required">*</span></label>
                                        <textarea name="small_description" id="small_description" class="form-control" rows="3" required>{{ $product->small_description }}</textarea>
                                        @error('small_description')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- اختيار الفئة -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category_id">{{ __('الفئة') }} <span class="required">*</span></label>
                                        <select name="category_id" id="category_id" class="form-control" required>
                                            <option value="" disabled>{{ __('اختر الفئة') }}</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- الوصف الكامل -->
                            <div class="form-group">
                                <label for="editor">{{ __('الوصف الكامل') }} <span class="required">*</span></label>
                                <textarea name="long_description" id="editor" class="form-control" required>{{ $product->long_description }}</textarea>
                                <small id="editor-error" class="text-danger" style="display: none;">هذا الحقل مطلوب!</small>
                            </div>

                            <!-- زر التحديث -->
                            <button type="submit" class="btn btn-primary">{{ __('تحديث المنتج') }}</button>
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