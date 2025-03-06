@extends('layouts.master')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('تعديل الباقة') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('الرئيسية') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('packages.index') }}">{{ __('الباقات') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('تعديل الباقة') }}</li>
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

                        <form action="{{ route('packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Image Upload -->
                            <div class="form-group">
                                <label for="image">الصورة</label>
                                <input type="file" class="form-control image" id="image" name="image" accept="image/*">
                                <div class="form-group">
                                    <img src="{{ $package->image ? asset('uploads/' . $package->image) : '' }}" 
                                         style="width: 100px" class="img-thumbnail image-preview" alt="الصورة">
                                </div>
                                @error('image')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Row 1: Name & Price -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">اسم الباقة <span class="required">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control" 
                                               value="{{ old('name', $package->name) }}" required>
                                        @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price">السعر <span class="required">*</span></label>
                                        <input type="text" name="price" id="price" class="form-control" 
                                               value="{{ old('price', $package->price) }}" required>
                                        @error('price')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Row 2: Number Date & Type Date -->
                            <div class="row">
                                <div class="col-md-6 mt-2">
                                    <label>المدة الزمنية</label>
                                    <input type="number" class="form-control" name="number_date" 
                                           value="{{ old('number_date', $package->number_date) }}">
                                    @error('number_date')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mt-2">
                                    <label>نوع المدة الزمنية</label>
                                    <select name="type_date" class="form-control">
                                        <option value="" disabled>اختر نوع التكرار</option>
                                        <option value="day" {{ old('type_date', $package->type_date) == 'day' ? 'selected' : '' }}>يوم</option>
                                        <option value="week" {{ old('type_date', $package->type_date) == 'week' ? 'selected' : '' }}>اسبوع</option>
                                        <option value="month" {{ old('type_date', $package->type_date) == 'month' ? 'selected' : '' }}>شهر</option>
                                    </select>
                                    @error('type_date')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Row 3: Number of Users & Visits -->
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="number_of_users_type">نوع عدد المستخدمين <span class="required">*</span></label>
                                        <select name="number_of_users_type" class="form-control" required>
                                            <option value="limited" {{ old('number_of_users_type', $package->number_of_users_type) == 'limited' ? 'selected' : '' }}>عدد محدود</option>
                                            <option value="unlimited" {{ old('number_of_users_type', $package->number_of_users_type) == 'unlimited' ? 'selected' : '' }}>غير محدود</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" id="users-group" style="display: none;">
                                        <label for="number_of_users">عدد المستخدمين <span class="required">*</span></label>
                                        <input type="number" name="number_of_users" id="number_of_users" class="form-control" 
                                               value="{{ old('number_of_users', $package->number_of_users) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="number_of_visits">عدد الزيارات <span class="required">*</span></label>
                                        <input type="number" name="number_of_visits" id="number_of_visits" class="form-control" 
                                               value="{{ old('number_of_visits', $package->number_of_visits) }}" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="form-group">
                                <label for="editor">الوصف <span class="required">*</span></label>
                                <textarea name="description" id="editor" class="form-control" required>{{ old('description', $package->description) }}</textarea>
                                <small id="editor-error" class="text-danger" style="display: none;">هذا الحقل مطلوب!</small>

                            </div>

                            <button type="submit" class="btn btn-success">{{ __('تحديث') }}</button>
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
        toggleNumberOfUsersField();

        $('select[name="number_of_users_type"]').on('change', function () {
            toggleNumberOfUsersField();
        });

        function toggleNumberOfUsersField() {
            let selectedValue = $('select[name="number_of_users_type"]').val();
            if (selectedValue === "limited") {
                $('#users-group').show();
                $('#number_of_users').attr('required', true);
            } else {
                $('#users-group').hide();
                $('#number_of_users').removeAttr('required').val('');
            }
        }
    });
</script>
@endsection
