@extends('layouts.master')
@section('title', 'الصلاحيات')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <section class="card">
                <div class="card-header">
                    <h4 class="card-title">قائمة الصلاحيات</h4>
                    <a href="{{ route('roles.create') }}" class="btn btn-primary">إضافة صلاحية</a>
                </div>

                <div class="card-body">
                    @include('dashboard.inc.alerts')

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>عدد الأذونات</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $index => $role)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->permissions->count() }}</td>
                                    <td>
                                        @if($role->name == 'الإدارة')
                                            <span class="badge badge-danger">لا يمكن تعديلها</span>
                                        @else
                                        <a href="{{ route('roles.show', $role->id) }}" class="btn btn-info btn-sm">عرض</a>
                                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            @if($roles->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center">لا توجد صلاحيات.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
