@extends('layouts.master')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('إضافة موظف جديد') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('الرئيسية') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ __('الموظفين') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('اضافة موظف') }}</li>
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

                        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                        
                            <div class="form-group">
                                <label for="image">الصورة</label>
                                <input type="file" class="form-control image" id="image" name="image" accept="image/*">
                                <div class="form-group">
                                    <img src="{{ asset('uploads/users/default.png') }}" 
                                         style="width: 100px" class="img-thumbnail image-preview" alt="الصورة">
                                </div>>
                                </div>
                                @error('image')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        
                            <div class="form-group">
                                <label for="name">الاسم <span class="required">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                                @error('name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        
                            <div class="form-group">
                                <label for="email">البريد الإلكتروني <span class="required">*</span></label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                                @error('email')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        
                            <div class="form-group">
                                <label for="password">كلمة المرور <span class="required">*</span></label>
                                <input type="password" name="password" id="password" class="form-control" required>
                                @error('password')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        
                            <div class="form-group">
                                <label for="password_confirmation">تأكيد كلمة المرور <span class="required">*</span></label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                            </div>
                        
                            <div class="form-group">
                                <label for="role">الصلاحيات <span class="required">*</span></label>
                                <select name="role" id="role" class="form-control" required>
                                    <option value="">الصلاحية</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        
                            <button type="submit" class="btn btn-success">{{ __('حفظ') }}</button>
                        </form>
                        
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
