@extends('layouts.master')
@section('title', 'تعديل الصلاحية')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <section class="card">
                <div class="card-header">
                    <h4 class="card-title">تعديل الصلاحية: {{ $role->name }}</h4>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">رجوع</a>
                </div>

                <div class="card-body">
                    @include('dashboard.inc.alerts')

                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>اسم الصلاحية</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>الأذونات</label>
                            <div class="row">
                                @foreach($permissions as $permission)
                                    <div class="col-md-4">
                                        <label>
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('permissions')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button class="btn btn-success">تحديث</button>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
