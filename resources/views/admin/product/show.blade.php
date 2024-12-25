@extends('layouts.admin')

@section('content')

<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Product Details</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Left Column: Basic Product Details -->
                <div class="col-md-6">
                    <h5 class="mb-3">Basic Information</h5>
                    <p><strong>Name:</strong> {{ $product->name }}</p>
                    <p><strong>Slug:</strong> {{ $product->slug }}</p>
                    <p><strong>SKU:</strong> {{ $product->sku }}</p>
                    <p><strong>Stock Status:</strong> 
                        <span class="badge bg-{{ $product->stock_status === 'instock' ? 'success' : 'danger' }}">
                            {{ ucfirst($product->stock_status) }}
                        </span>
                    </p>
                    <p><strong>Featured:</strong> 
                        {{ $product->featured ? 'Yes' : 'No' }}
                    </p>
                    <p><strong>Quantity:</strong> {{ $product->quantity }}</p>
                </div>

                <!-- Right Column: Pricing and Images -->
                <div class="col-md-6">
                    <h5 class="mb-3">Pricing</h5>
                    <p><strong>Regular Price:</strong> ${{ number_format($product->regular_price, 2) }}</p>
                    <p><strong>Sale Price:</strong> ${{ number_format($product->sale_price, 2) }}</p>
                    
                    <h5 class="mb-3">Image</h5>
                    <div class="mb-3">
                        @if($product->image)
                            <img src="{{ $product->image }}" alt="Product Image" class="img-fluid rounded" style="max-width: 150px;">
                        @else
                            <p>No Image Available</p>
                        @endif
                    </div>

                    <h5 class="mb-3">Gallery Images</h5>
                    <div class="d-flex flex-wrap">
                        @if (!empty($product->images))
                            @php
                                $galleryImages = json_decode($product->images, true);
                            @endphp
                            @foreach ($galleryImages as $image)
                                <img src="{{ asset('storage/' . $image) }}" alt="Gallery Image" class="img-thumbnail me-2 mb-2" style="width: 80px; height: 80px; object-fit: cover;">
                            @endforeach
                        @else
                            <p>No Gallery Images</p>
                        @endif
                    </div>
                </div>
            </div>

            <hr>

            <!-- Description Section -->
            <div class="row">
                <div class="col-12">
                    <h5 class="mb-3">Descriptions</h5>
                    <p><strong>Short Description:</strong></p>
                    <p class="wrap" style="word-wrap: break-word; white-space: normal;">{!! $product->short_description !!}</p>

                    <p><strong>Description:</strong></p>
                    <p class="wrap" style="word-wrap: break-word; white-space: normal;">{!! $product->description !!}</p>
                </div>
            </div>

            <hr>

            <!-- Category and Brand -->
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Brand:</strong> {{ $product->brand->name ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection