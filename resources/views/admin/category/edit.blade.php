@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Brand Information</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="#"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><a href="#"><div class="text-tiny">Cateogries</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><a href="{{ route('admin.category-index') }}"><div class="text-tiny">Back</div></a></li>
            </ul>
        </div>
        <div class="wg-box">
            <form class="form-new-product form-style-1" action="{{ route('admin.category-update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <fieldset>
                    <div class="body-title">Category Name <span class="tf-color-1">*</span></div>
                    <input type="text" placeholder="Category Name" name="name" value="{{ old('name')?? $category->name }}" required>
                    @error('name')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </fieldset>
                <fieldset>
                    <div class="body-title">Brand Slug <span class="tf-color-1">*</span></div>
                    <input type="text" placeholder="Brand Slug" name="slug" value="{{ old('slug') ?? $category->slug }}" required>
                    @error('slug')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </fieldset>
                <fieldset>
                    <div class="body-title">Upload Image <span class="tf-color-1">*</span></div>
                    <div class="upload-image flex-grow">
                        <div id="imgpreview" style="width: 100px; height: 100px;">
                            <img src="{{ $category->image }}" alt="Image Preview" class="effect8">
                        </div>
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon"><i class="icon-upload-cloud"></i></span>
                                <span class="body-text">Drop your image here or click to browse</span>
                                <input type="file" id="myFile" name="image" accept="image/*" required>
                            </label>
                        </div>
                    </div>
                    @error('image')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </fieldset>
                <div class="bot">
                    <button class="tf-button w208" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        // Image preview
        $('#myFile').on('change', function () {
            const [file] = this.files;
            if (file) {
                $("#imgpreview img").attr('src', URL.createObjectURL(file)).show();
                $("#imgpreview").show();
            }
        });

        // Auto-generate slug from name
        $("input[name='name']").on('input', function () {
            const name = $(this).val();
            $("input[name='slug']").val(stringToSlug(name));
        });

        // Function to convert string to slug
        function stringToSlug(text) {
            return text
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '') // Remove invalid characters
                .replace(/[\s_-]+/g, '-') // Collapse whitespace and replace by -
                .replace(/^-+|-+$/g, ''); // Trim leading and trailing dashes
        }
    });
</script>
@endpush
