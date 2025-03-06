@extends('layouts.master')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('تعديل المنتج') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ __('المنتجات') }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('تعديل المنتج') }}</li>
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
                                    <h4 class="card-title">{{ __('تعديل المنتج') }}</h4>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form action="{{ route('products.update', $product->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <!-- Main Title -->
                                            <div class="form-group col-8">
                                                <label for="main_title">{{ __('العنوان الرئيسي') }}</label>
                                                <input type="text" id="main_title" name="main_title" class="form-control"
                                                    value="{{ old('main_title', $product->main_title) }}" required>
                                            </div>

                                            <!-- Second Title -->
                                            <div class="form-group col-8">
                                                <label for="secand_title">{{ __('العنوان الفرعي') }}</label>
                                                <input type="text" id="secand_title" name="secand_title"
                                                    class="form-control"
                                                    value="{{ old('secand_title', $product->secand_title) }}" required>
                                            </div>

                                            <!-- Price -->
                                            <div class="form-group col-8">
                                                <label for="price">{{ __('السعر') }}</label>
                                                <input type="text" id="price" name="price" class="form-control"
                                                    value="{{ old('price', $product->price) }}" required>
                                            </div>

                                            <!-- Discount Price -->
                                            <div class="form-group col-8">
                                                <label for="descount_price">{{ __('سعر الخصم') }}</label>
                                                <input type="text" id="descount_price" name="descount_price"
                                                    class="form-control"
                                                    value="{{ old('descount_price', $product->descount_price) }}" required>
                                            </div>

                                            <!-- Stars -->
                                            <div class="form-group col-8">
                                                <label for="stars">{{ __('التقييم (نجوم)') }}</label>
                                                <input type="number" id="stars" name="stars" class="form-control"
                                                    value="{{ old('stars', $product->stars) }}" min="1"
                                                    max="5" required>
                                            </div>

                                            <!-- Rate -->
                                            <div class="form-group col-8">
                                                <label for="rate">{{ __('معدل التقييم') }}</label>
                                                <input type="text" id="rate" name="rate" class="form-control"
                                                    value="{{ old('rate', $product->rate) }}" required>
                                            </div>

                                            <!-- Review -->
                                            <div class="form-group col-8">
                                                <label for="review">{{ __('المراجعة') }}</label>
                                                <input type="text" id="review" name="review" class="form-control"
                                                    value="{{ old('review', $product->review) }}" required>
                                            </div>

                                            <!-- Description -->
                                            <div class="form-group col-8">
                                                <label for="description">{{ __('الوصف') }}</label>
                                                <textarea id="description" name="description" class="ckeditor  form-control" rows="4" required>{{ old('description', $product->description) }}</textarea>
                                            </div>

                                            <!-- Images (Multiple) -->
                                            <div class="form-group col-8">
                                                <label for="images">{{ __('الصور') }}</label>
                                                <input type="file" name="images[]" id="images" class="form-control"
                                                    multiple onchange="previewImages()">
                                            </div>

                                            <!-- Image Preview Container -->
                                            <!-- Image Preview Container -->
                                            <div id="image-preview"
                                                style="margin-top: 10px; display: flex; gap: 10px; flex-wrap: wrap;">
                                                <!-- Show previously uploaded images -->
                                                @foreach (json_decode($product->images, true) as $key => $image)
                                                    <div class="image-container"
                                                        style="position: relative; width: 100px; height: 100px;">
                                                        <img src="{{ asset('uploads/' . $image) }}"
                                                            style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                                                        <span class="delete-image" data-index="{{ $key }}"
                                                            data-path="{{ $image }}"
                                                            style="position: absolute; top: 5px; right: 5px; color: white; background-color: red; border-radius: 50%; cursor: pointer; padding: 5px;">&times;</span>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- Hidden Input to Track Images Marked for Deletion -->
                                            <input type="hidden" name="deleted_images" id="deleted_images">

                                            <div class="form-group col-8">
                                                <label for="features">{{ __('تص المميزات') }}</label>
                                                <textarea id="features" name="features" class="ckeditor  form-control" rows="4" required>{{ old('features', $product->features) }}</textarea>
                                            </div>

                                            <div class="form-group col-8">
                                                <label for="shipping">{{ __('تص shipping') }}</label>
                                                <textarea id="shipping" name="shipping" class="ckeditor  form-control" rows="4" required>{{ old('shipping', $product->shipping) }}</textarea>
                                            </div>
                                            <div class="form-group col-8">
                                                <label for="trial">{{ __('تص 90 Night Risk-Free Trial') }}</label>
                                                <textarea id="trial" name="trial" class="ckeditor  form-control" rows="4" required>{{ old('trial', $product->trial) }}</textarea>
                                            </div>

                                            <!-- Submit Button -->
                                            <button type="submit" class="btn btn-success">{{ __('تحديث') }}</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            const deletedImagesInput = document.getElementById('deleted_images');
            let deletedImages = [];

            // Handle deletion of previously uploaded images
            document.querySelectorAll('.delete-image').forEach(deleteBtn => {
                deleteBtn.addEventListener('click', function() {
                    const imageContainer = this.parentElement;
                    const imagePath = this.dataset.path;

                    // Add the image path to the deleted images list
                    deletedImages.push(imagePath);
                    deletedImagesInput.value = JSON.stringify(deletedImages);

                    // Remove the image from the preview
                    imageContainer.remove();
                });
            });

            // Handle deletion of newly added images
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
        });
    </script>
    <script>
        let selectedFiles = [];

        function previewImages() {
            const previewContainer = document.getElementById('image-preview');
            const files = document.getElementById('images').files;

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
