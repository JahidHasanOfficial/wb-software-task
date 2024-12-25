@extends('layouts.app')
@section('title', 'Single Product Page - ' . config('app.name', 'E-Commerce'))
@section('content')

<div class="container">
    <main class="pt-90">
        <div class="mb-md-1 pb-md-3"></div>
        <section class="product-single container">
          <div class="row">
            <div class="col-lg-7">
                <div class="product-single__media" data-media-type="vertical-thumbnail">
                    <!-- Main Image Area -->
                    <div class="product-single__image">
                      <div class="swiper-container">
                        <div class="swiper-wrapper">
                          @if (!empty($product->images))
                            @php
                              $galleryImages = json_decode($product->images, true);
                            @endphp
                            @foreach ($galleryImages as $image)
                              <div class="swiper-slide product-single__image-item">
                                <img loading="lazy" class="h-auto" src="{{ asset('storage/' . $image) }}" width="674" height="674" alt="Product Image" />
                                <a data-fancybox="gallery" href="{{ asset('storage/' . $image) }}" data-bs-toggle="tooltip"
                                  data-bs-placement="left" title="Zoom">
                                  <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_zoom"></use>
                                  </svg>
                                </a>
                              </div>
                            @endforeach
                          @else
                            <div class="swiper-slide product-single__image-item">
                              <p>No Gallery Images Available</p>
                            </div>
                          @endif
                        </div>
                        <!-- Swiper Navigation -->
                        <div class="swiper-button-prev">
                          <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_prev_sm"></use>
                          </svg>
                        </div>
                        <div class="swiper-button-next">
                          <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_next_sm"></use>
                          </svg>
                        </div>
                      </div>
                    </div>
                  
                    <!-- Thumbnail Images -->
                    <div class="product-single__thumbnail">
                      <div class="swiper-container">
                        <div class="swiper-wrapper">
                          @if (!empty($galleryImages))
                            @foreach ($galleryImages as $image)
                              <div class="swiper-slide product-single__image-item">
                                <img loading="lazy" class="h-auto" src="{{ asset('storage/' . $image) }}" width="104" height="104" alt="Thumbnail Image" />
                              </div>
                            @endforeach
                          @else
                            <div class="swiper-slide product-single__image-item">
                              <p>No Thumbnails Available</p>
                            </div>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                  <script>
                    const swiperMain = new Swiper('.product-single__image .swiper-container', {
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  loop: true,
});

const swiperThumbnail = new Swiper('.product-single__thumbnail .swiper-container', {
  slidesPerView: 4,
  spaceBetween: 10,
  watchSlidesVisibility: true,
  watchSlidesProgress: true,
});

swiperMain.controller.control = swiperThumbnail;
swiperThumbnail.controller.control = swiperMain;

                  </script>
            </div>
            <div class="col-lg-5">
              <div class="d-flex justify-content-between mb-4 pb-md-2">
                <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                  <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
                  <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                  <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">The Shop</a>
                </div><!-- /.breadcrumb -->
    
              
              </div>
              <div class="meta-item">
                <label>Brand:</label>
                <span>{{ $product->brand->name ?? '' }}</span>
              </div>
              <h1 class="product-single__name">{{ $product->name ? $product->name : '' }}</h1>
              
              <div class="product-single__price">
                <span class="current-price">
                    @if ($product->sale_price)
                    <s>${{ $product->regular_price }}</s> ${{ $product->sale_price }}</s>
                @else
                    ${{ $product->regular_price }}
                @endif
                </span>
              </div>
              <div class="product-single__short-desc">
                <p>{{ $product->short_description ? $product->short_description : '' }}</p>
              </div>
              @if (Cart::instance('cart')->content()->where('id', $product->id)->count() > 0)
              <a href="{{ route('cart.index') }}" class="btn btn-primary btn-addtocart">Go To Cart</a>
            @else
            <form name="addtocart-form" method="post" action="{{ route('cart.add') }}" enctype="multipart/form-data">
              @csrf
              <div class="product-single__addtocart">
                <div class="qty-control position-relative">
                  <input type="number" name="quantity" value="1" min="1" class="qty-control__number text-center">
                  <div class="qty-control__reduce">-</div>
                  <div class="qty-control__increase">+</div>
                </div><!-- .qty-control -->
                <input type="hidden" name="id" value="{{ $product->id }}">
                <input type="hidden" name="name" value="{{ $product->name }}">
                <input type="hidden" name="price" value="{{ $product->sale_price ? $product->sale_price : $product->regular_price }}">
                <button type="submit" class="btn btn-primary btn-addtocart" data-aside="cartDrawer">Add to
                  Cart</button>
              </div>
            </form>
          @endif
            
              <div class="product-single__meta-info">
                <div class="meta-item">
                  <label>SKU:</label>
                  <span>{{ $product->sku ? $product->sku : '' }}</span>
                </div>
                <div class="meta-item">
                  <label>Categories:</label>
                  <span>{{ $product->category ? $product->category->name : '' }}</span>
                </div>
                <div class="meta-item">
                  <label>Tags:</label>
                  <span>biker, black, bomber, leather</span>
                </div>
              </div>
            </div>
          </div>
          <div class="product-single__details-tab">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link nav-link_underscore active" id="tab-description-tab" data-bs-toggle="tab"
                  href="#tab-description" role="tab" aria-controls="tab-description" aria-selected="true">Description</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link nav-link_underscore" id="tab-additional-info-tab" data-bs-toggle="tab"
                  href="#tab-additional-info" role="tab" aria-controls="tab-additional-info"
                  aria-selected="false">Additional Information</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link nav-link_underscore" id="tab-reviews-tab" data-bs-toggle="tab" href="#tab-reviews"
                  role="tab" aria-controls="tab-reviews" aria-selected="false">Reviews (2)</a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="tab-description" role="tabpanel"
                aria-labelledby="tab-description-tab">
                <div class="product-single__description">
                  <h3 class="block-title mb-4">Sed do eiusmod tempor incididunt ut labore</h3>
                  <p class="content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                    laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                    velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt
                    in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus
                    error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo
                    inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                  <div class="row">
                    <div class="col-lg-6">
                      <h3 class="block-title">Why choose product?</h3>
                      <ul class="list text-list">
                        <li>Creat by cotton fibric with soft and smooth</li>
                        <li>Simple, Configurable (e.g. size, color, etc.), bundled</li>
                        <li>Downloadable/Digital Products, Virtual Products</li>
                      </ul>
                    </div>
                    <div class="col-lg-6">
                      <h3 class="block-title">Sample Number List</h3>
                      <ol class="list text-list">
                        <li>Create Store-specific attrittbutes on the fly</li>
                        <li>Simple, Configurable (e.g. size, color, etc.), bundled</li>
                        <li>Downloadable/Digital Products, Virtual Products</li>
                      </ol>
                    </div>
                  </div>
                  <h3 class="block-title mb-0">Lining</h3>
                  <p class="content">100% Polyester, Main: 100% Polyester.</p>
                </div>
              </div>
              <div class="tab-pane fade" id="tab-additional-info" role="tabpanel" aria-labelledby="tab-additional-info-tab">
                <div class="product-single__addtional-info">
                  <div class="item">
                    <label class="h6">Weight</label>
                    <span>1.25 kg</span>
                  </div>
                  <div class="item">
                    <label class="h6">Dimensions</label>
                    <span>90 x 60 x 90 cm</span>
                  </div>
                  <div class="item">
                    <label class="h6">Size</label>
                    <span>XS, S, M, L, XL</span>
                  </div>
                  <div class="item">
                    <label class="h6">Color</label>
                    <span>Black, Orange, White</span>
                  </div>
                  <div class="item">
                    <label class="h6">Storage</label>
                    <span>Relaxed fit shirt-style dress with a rugged</span>
                  </div>
                </div>
              </div>
           
            </div>
          </div>
        </section>
       
      </main>
</div>

@endsection