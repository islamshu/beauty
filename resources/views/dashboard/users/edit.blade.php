@extends('layouts.master')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('تعديل الموظف') }}</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('الرئيسية') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ __('الموظفين') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('تعديل موظف') }}</li>
                </ol>
            </div>
           
        </div>
        <div class="content-body">
            <section>
                <div class="card">
                    <div class="card-body">
                        @include('dashboard.inc.alerts')

                        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- Important for updating data -->
                        
                            <!-- Image Upload -->
                            <div class="form-group">
                                <label for="image">الصورة</label>
                                <input type="file" class="form-control image" id="image" name="image" accept="image/*">
                                <div class="form-group">
                                    <img src="{{ asset('uploads/'.$user->image) }}" 
                                         style="width: 100px" class="img-thumbnail image-preview" alt="الصورة">
                                </div>
                                @error('image')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        
                            <!-- Name -->
                            <div class="form-group">
                                <label for="name">الاسم <span class="required">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        
                            <!-- Email -->
                            <div class="form-group">
                                <label for="email">البريد الإلكتروني <span class="required">*</span></label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        
                            <!-- Password (Optional) -->
                            <div class="form-group">
                                <label for="password">كلمة المرور (اتركه فارغًا إذا لم ترد تغييره)</label>
                                <input type="password" name="password" id="password" class="form-control">
                                @error('password')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        
                            <!-- Confirm Password -->
                            <div class="form-group">
                                <label for="password_confirmation">تأكيد كلمة المرور</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                            </div>
                        
                            <!-- Role Selection -->
                         <div class="form-group">
    <label for="role">الصلاحيات <span class="required">*</span></label>
    <select name="role" id="role" class="form-control" required>
        <option value="">الصلاحية</option>
        @foreach($roles as $roles)
            <option value="{{ $roles->name }}" {{ old('role', $user->roles->first()->name ?? '') == $roles->name ? 'selected' : '' }}>
                {{ $roles->name }}
            </option>
        @endforeach
    </select>
    @error('role')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
                        
                            <button type="submit" class="btn btn-primary">{{ __('تحديث') }}</button>
                        </form>
                        
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
