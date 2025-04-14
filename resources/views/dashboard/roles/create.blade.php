@extends('layouts.master')
@section('title', 'إضافة صلاحية')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('إضافة صلاحية جديدة') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">{{ __('الصلاحيات') }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('اضافة صلاحية') }}</li>
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

                            <form action="{{ route('roles.store') }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="name">اسم الصلاحية <span class="required">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name') }}" required>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>الأذونات <span class="required">*</span></label>
                                    <div class="row">
                                        @foreach ($permissions as $permission)
                                            <div class="col-md-3">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('permissions')
                                        <small class="text-danger d-block">{{ $message }}</small>
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
