@extends('layouts.master')
@section('title','من نحن')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('من نحن') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('الرئيسية') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('من نحن') }}</li>
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

                        <form action="{{ route('aboutus.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                        
                            <!-- Image Upload -->
                            <div class="form-group">
                                <label for="image">الصورة</label>
                                <input type="file" class="form-control image" id="image" name="image" accept="image/*">
                                <div class="form-group">
                                    <img src="{{asset('uploads/'.$about->image)}}" style="width: 100px" class="img-thumbnail image-preview" alt="الصورة">
                                </div>
                                @error('image')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        
                            <!-- Row 1: Name & Price -->
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="first_title">العنوان <span class="required">*</span> </label>
                                        <input type="text" required name="title" id="title" class="form-control" value="{{ old('title', $about->title) }}" >
                                        @error('title')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                        
                                
                            </div>
                        
                            <!-- Row 2: Number Date & Type Date -->
                            <div class="form-group">
                                <label for="editor">الوصف <span class="required">*</span></label>
                                <textarea name="descritpion" id="editor" class="form-control" required>{{ old('descritpion', $about->descritpion) }}</textarea>
                                <small id="editor-error" class="text-danger" style="display: none;">هذا الحقل مطلوب!</small>
                            </div>
                        
                            
                        
                            <button type="submit" class="btn btn-success mt-3">{{ __('حفظ') }}</button>
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
        // عند تحميل الصفحة، تحقق من الخيار المحدد
        toggleNumberOfUsersField();

        // عند تغيير القيمة في القائمة المنسدلة
        $('select[name="number_of_users_type"]').on('change', function () {
            toggleNumberOfUsersField();
        });

        function toggleNumberOfUsersField() {
            let selectedValue = $('select[name="number_of_users_type"]').val();
            if (selectedValue === "limited") {
                $('#number_of_users').closest('.form-group').show();
                $('#number_of_users').attr('required', true);
            } else {
                $('#number_of_users').closest('.form-group').hide();
                $('#number_of_users').removeAttr('required').val('');
            }
        }
    });
</script>
@endsection
