@extends('layouts.master')
@section('title','قائمة الصور')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('معرض الصور') }}</h3>
                </div>
            </div>
            <div class="content-body">
                <section>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('قائمة الصور') }}</h4>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#addImageModal">{{ __('إضافة صورة جديدة') }}</button>
                        </div>
                        <div class="card-body">
                            @include('dashboard.inc.alerts')

                            <table class="table" id="galleriestable">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <th>{{ __('الصورة') }}</th>
                                        <th>{{ __('الفئة') }}</th>
                                        <th>{{ __('الإجراءات') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($galleries as $key => $gallery)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><img src="{{ asset('uploads/' . $gallery->image) }}" width="80" height="80" alt=""></td>
                                            <td>{{ $gallery->category->name }}</td>
                                            <td>
                                                <form action="{{ route('galleries.destroy', $gallery->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('هل أنت متأكد؟') }}')">{{ __('حذف') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Modal for adding new image -->
    <div class="modal fade" id="addImageModal" tabindex="-1" role="dialog" aria-labelledby="addImageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addImageModalLabel">{{ __('إضافة صورة جديدة') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('galleries.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="image">{{ __('الصورة') }}</label>
                            <input type="file" class="form-control" name="image" required>
                        </div>
                        <div class="form-group">
                            <label for="category_id">{{ __('الفئة') }}</label>
                            <select class="form-control" name="category_id" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('إضافة') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
