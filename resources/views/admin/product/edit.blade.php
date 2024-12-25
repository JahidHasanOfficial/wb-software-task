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
            <form class="tf-section-2 form-add-product" method="POST" action="{{ route('admin.product-update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
            <div class="wg-box">
                <fieldset class="name">
                    <div class="body-title mb-10">Product name <span class="tf-color-1">*</span>
                    </div>
                    <input class="mb-10" type="text" placeholder="Enter product name"
                        name="name" tabindex="0" value="{{ old('name', $product->name)}}" aria-required="true" required="">
                    <div class="text-tiny">Do not exceed 100 characters when entering the
                        product name.</div>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Enter product slug"
                        name="slug" tabindex="0" value="{{ old('slug', $product->slug)}}" aria-required="true" required="">
                    <div class="text-tiny">Do not exceed 100 characters when entering the
                        product name.</div>
                </fieldset>

                <div class="gap22 cols">
                    <fieldset class="category">
                        <div class="body-title mb-10">Category <span class="tf-color-1">*</span>
                        </div>
                        <div class="select">
                            <select class="" name="category_id">
                                <option>Choose category</option>
                               @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                               @endforeach

                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="brand">
                        <div class="body-title mb-10">Brand <span class="tf-color-1">*</span>
                        </div>
                        <div class="select">
                            <select class="" name="brand_id">
                                <option>Choose Brand</option>
                               @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                               @endforeach

                            </select>
                        </div>
                    </fieldset>
                </div>

                <fieldset class="shortdescription">
                    <div class="body-title mb-10">Short Description <span
                            class="tf-color-1">*</span></div>
                    <textarea class="mb-10 ht-150" name="short_description"
                        placeholder="Short Description" tabindex="0" aria-required="true"
                           > {{ old('short_description', $product->short_description) }}</textarea>
                    <div class="text-tiny">Do not exceed 100 characters when entering the
                        product name.</div>
                </fieldset>

                <fieldset class="description">
                    <div class="body-title mb-10">Description <span class="tf-color-1">*</span>
                    </div>
                    <textarea class="mb-10" name="description" placeholder="Description"
                        tabindex="0" aria-required="true" required="">{{ old('description', $product->description) }}</textarea>
                    <div class="text-tiny">Do not exceed 100 characters when entering the
                        product name.</div>
                </fieldset>
            </div>
            <div class="wg-box">
                <fieldset>
                    {{-- <div class="body-title">Upload images <span class="tf-color-1">*</span>
                    </div>
                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreview" style="display:none">
                            <img src="../../../localhost_8000/images/upload/upload-1.png"
                                class="effect8" alt="">
                        </div>
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your images here or select <span
                                        class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div> --}}

                    <div class="body-title">Upload images <span class="tf-color-1">*</span></div>
<div class="upload-image flex-grow">
    <!-- Display the old or existing image -->
    <div class="item" id="imgpreview" style="{{ $product->image ? '' : 'display:none;' }}">
        @if ($product->image)
            <img src="{{ asset($product->image) }}" class="effect8" alt="Uploaded Image">
        @endif
    </div>

    <!-- File upload input -->
    <div id="upload-file" class="item up-load">
        <label class="uploadfile" for="myFile">
            <span class="icon">
                <i class="icon-upload-cloud"></i>
            </span>
            <span class="body-text">Drop your images here or select <span class="tf-color">click to browse</span></span>
            <input type="file" id="myFile" name="image" accept="image/*">
        </label>
    </div>
</div>

                </fieldset>

                <fieldset>
                    {{-- <div class="body-title mb-10">Upload Gallery Images</div>
                    <div class="upload-image mb-16">
                        <div id="galUpload" class="item up-load">
                            <label class="uploadfile" for="gFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="text-tiny">Drop your images here or select <span
                                        class="tf-color">click to browse</span></span>
                                <input type="file" id="gFile" name="images[]" accept="image/*"
                                    multiple="">
                            </label>
                        </div>
                    </div> --}}
<style>
    .old-gallery-images {
    display: inline-block;
    gap: 10px;
    margin-bottom: 16px;
}

.gallery-item img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border: 1px solid #ddd;
    border-radius: 4px;
}

</style>
                    <div class="body-title mb-10">Upload Gallery Images</div>
                    <div class="upload-image mb-16">
                        <!-- Display Old Images -->
                        <div class="old-gallery-images">
                            @if (!empty($product->images))
                                @php
                                    $galleryImages = json_decode($product->images, true);
                                @endphp
                                @foreach ($galleryImages as $image)
                                    <div class="gallery-item">
                                        <img src="{{ asset('storage/' . $image) }}" class="effect8" alt="Gallery Image">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    
                        <!-- File Upload Input -->
                        <div id="galUpload" class="item up-load">
                            <label class="uploadfile" for="gFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="text-tiny">Drop your images here or select <span class="tf-color">click to browse</span></span>
                                <input type="file" id="gFile" name="images[]" accept="image/*" multiple>
                            </label>
                        </div>
                    </div>
                    

                </fieldset>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Regular Price <span
                                class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter regular price"
                            name="regular_price" tabindex="0" value="{{ old('regular_price', $product->regular_price) }}" aria-required="true"
                            required="">
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Sale Price <span
                                class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter sale price"
                            name="sale_price" tabindex="0" value="{{ old('sale_price', $product->sale_price) }}" aria-required="true"
                            required="">
                    </fieldset>
                </div>


                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">sku <span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10" type="text" placeholder="Enter sku" name="sku"
                            tabindex="0" value="{{ old('sku', $product->sku) }}" aria-required="true" required="">
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10" type="text" placeholder="Enter quantity"
                            name="quantity" tabindex="0" value="{{ old('quantity', $product->quantity) }}" aria-required="true"
                            required="">
                    </fieldset>
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Stock</div>
                        <div class="select mb-10">
                            <select class="" name="stock_status">
                                <option value="instock" {{ old('stock_status', $product->stock_status) == 'instock' ? 'selected' : '' }}>InStock</option>
                                <option value="outofstock" {{ old('stock_status', $product->stock_status) == 'outofstock' ? 'selected' : '' }}>Out of Stock</option>
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Featured</div>
                        <div class="select mb-10">
                            <select class="" name="featured">
                                <option value="0" {{ old('featured', $product->featured) == '0' ? 'selected' : '' }}>No</option>
                                <option value="1" {{ old('featured', $product->featured) == '1' ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>
                    </fieldset>
                </div>
                
                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Add product</button>
                </div>
            </div>
        </form>
        <!-- /form-add-product -->
    </div>
    <!-- /main-content-wrap -->
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

        // // Gallery preview
        // $('#gFile').on('change', function () {
        //     const photoInp = $("gFile");
        //     const gphotos = this;
        //     $.each(gphotos, function (key, value) {
        //         $("#galUpload").prepend(`<div class="item"><img src="${URL.createObjectURL(value)}" alt=""></div>`);
        //     });
        //     })

        // Gallery preview
$('#gFile').on('change', function () {
    const gphotos = this.files; // Get the selected files
    // Loop through the files and add preview
    $.each(gphotos, function (key, file) {
        const imgURL = URL.createObjectURL(file);
        const previewHTML = `<div class="item"><img src="${imgURL}" alt=""></div>`;
        $("#galUpload").before(previewHTML); // Add images before the upload button
    });
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
