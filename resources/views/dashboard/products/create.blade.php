@extends('layouts.master')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('Add New Product') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ __('Products') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('Add New') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="validation">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ __('Add New Product') }}</h4>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            
                                            <!-- Main Title -->
                                            <div class="form-group col-8">
                                                <label for="main_title">{{ __('Main Title') }}</label>
                                                <input type="text" id="main_title" name="main_title" class="form-control" value="{{ old('main_title') }}" placeholder="{{ __('Enter main title') }}" required>
                                            </div>

                                            <!-- Second Title -->
                                            <div class="form-group col-8">
                                                <label for="secand_title">{{ __('Second Title') }}</label>
                                                <input type="text" id="secand_title" name="secand_title" class="form-control" value="{{ old('secand_title') }}" placeholder="{{ __('Enter second title') }}" required>
                                            </div>

                                            <!-- Discount Price -->
                                            <div class="form-group col-8">
                                                <label for="descount_price">{{ __('Discount Price') }}</label>
                                                <input type="text" id="descount_price" name="descount_price" class="form-control" value="{{ old('descount_price') }}" placeholder="{{ __('Enter discount price') }}" required>
                                            </div>

                                            <!-- Price -->
                                            <div class="form-group col-8">
                                                <label for="price">{{ __('Price') }}</label>
                                                <input type="text" id="price" name="price" class="form-control" value="{{ old('price') }}" placeholder="{{ __('Enter price') }}" required>
                                            </div>

                                            <!-- Stars -->
                                            <div class="form-group col-8">
                                                <label for="stars">{{ __('Stars') }}</label>
                                                <input type="number" id="stars" name="stars" class="form-control" value="{{ old('stars') }}" min="1" max="5" placeholder="{{ __('Enter star rating') }}" required>
                                            </div>

                                            <!-- Rate -->
                                            <div class="form-group col-8">
                                                <label for="rate">{{ __('Rate') }}</label>
                                                <input type="text" id="rate" name="rate" class="form-control" value="{{ old('rate') }}" placeholder="{{ __('Enter rate') }}" required>
                                            </div>

                                            <!-- Review -->
                                            <div class="form-group col-8">
                                                <label for="review">{{ __('Review') }}</label>
                                                <input type="text" id="review" name="review" class="form-control" value="{{ old('review') }}" placeholder="{{ __('Enter review') }}" required>
                                            </div>

                                            <!-- Description -->
                                            <div class="form-group col-8">
                                                <label for="description">{{ __('Description') }}</label>
                                                <textarea id="description" name="description" class="form-control" rows="4" placeholder="{{ __('Enter product description') }}">{{ old('description') }}</textarea>
                                            </div>

                                            <!-- Images (Multiple) -->
                                            <div class="form-group col-8">
                                                <label for="images">{{ __('Images') }}</label>
                                                <input type="file" name="images[]" id="images" class="form-control" multiple onchange="previewImages()">
                                            </div>

                                            <!-- Image Preview Container -->
                                            <div id="image-preview" style="margin-top: 10px; display: flex; gap: 10px; flex-wrap: wrap;"></div>

                                            <!-- Submit Button -->
                                            <button type="submit" class="btn btn-success">{{ __('Save') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

@section('script')
    <script>
        let selectedFiles = [];

        function previewImages() {
            const previewContainer = document.getElementById('image-preview');
            const files = document.getElementById('images').files;

            // Clear previous previews
            previewContainer.innerHTML = "";
            selectedFiles = Array.from(files);

            selectedFiles.forEach((file, index) => {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const imageContainer = document.createElement('div');
                    imageContainer.style.position = "relative";
                    imageContainer.style.width = "100px";
                    imageContainer.style.height = "100px";
                    imageContainer.style.marginRight = "10px";

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = "100%";
                    img.style.height = "100%";
                    img.style.objectFit = "cover";
                    img.style.borderRadius = "8px";

                    const deleteBtn = document.createElement('span');
                    deleteBtn.innerHTML = "&times;";
                    deleteBtn.style.position = "absolute";
                    deleteBtn.style.top = "5px";
                    deleteBtn.style.right = "5px";
                    deleteBtn.style.color = "white";
                    deleteBtn.style.backgroundColor = "red";
                    deleteBtn.style.borderRadius = "50%";
                    deleteBtn.style.cursor = "pointer";
                    deleteBtn.style.padding = "5px";
                    deleteBtn.onclick = function() {
                        removeImage(index);
                    };

                    imageContainer.appendChild(img);
                    imageContainer.appendChild(deleteBtn);
                    previewContainer.appendChild(imageContainer);
                }

                reader.readAsDataURL(file);
            });
        }

        function removeImage(index) {
            selectedFiles.splice(index, 1);
            updateFileInput();
            previewImages();
        }

        function updateFileInput() {
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => {
                dataTransfer.items.add(file);
            });
            document.getElementById('images').files = dataTransfer.files;
        }
    </script>
    
@endsection

@endsection

