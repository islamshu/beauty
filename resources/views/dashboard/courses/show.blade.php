@extends('layouts.master')
@section('title','مشاهدة الدورة')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('تعديل الكورس') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('الرئيسية') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">{{ __('الكورسات') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('تعديل الكورس') }}</li>
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

                        <form method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <!-- صورة الكورس -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">{{ __('الصورة') }}</label>
                                        <div class="mt-2">
                                            @if ($course->image)
                                                <img src="{{ asset('uploads/' . $course->image) }}" style="width: 100px" class="img-thumbnail image-preview" alt="الصورة">
                                            @else
                                                <img src="" style="width: 100px" class="img-thumbnail image-preview" alt="الصورة">
                                            @endif
                                        </div>
                                        @error('image')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- عنوان الكورس -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">{{ __('عنوان الكورس') }} </label>
                                        <input type="text" disabled name="title" id="title" class="form-control" value="{{ $course->title }}" required>
                                        @error('title')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- سعر الكورس -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price">{{ __('السعر') }} </label>
                                        <input type="number" disabled name="price" id="price" class="form-control" value="{{ $course->price }}" required>
                                        @error('price')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="show_price">عرض السعر</label>
                                        <input type="checkbox" disabled name="show_price" id="show_price" value="1" {{ $course->show_price ? 'checked' : '' }}>
                                    </div>
                                </div>

                                <!-- اختيار الفئة -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category_id">{{ __('الفئة') }} </label>
                                        <select disabled name="category_id" id="category_id" class="form-control" required>
                                            <option value="" disabled>{{ __('اختر الفئة') }}</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ $course->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- الوصف -->
                            <div class="form-group">
                                <label for="editor">الوصف </label>
                                <textarea disabled name="description" rows="3" cols="3" class="form-control" required>{!!$course->description!!}</textarea>
                            </div>

                            <!-- زر التحديث -->
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