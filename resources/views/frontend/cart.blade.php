@extends('layouts.app')
@section('title', 'Cart Page - ' . config('app.name', 'E-Commerce'))
@section('content')

<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
      <h2 class="page-title">Cart</h2>
      <div class="checkout-steps">
        <a href="javascript:void(0)" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">01</span>
          <span class="checkout-steps__item-title">
            <span>Shopping Bag</span>
            <em>Manage Your Items List</em>
          </span>
        </a>
        <a href="javascript:void(0)" class="checkout-steps__item">
          <span class="checkout-steps__item-number">02</span>
          <span class="checkout-steps__item-title">
            <span>Shipping and Checkout</span>
            <em>Checkout Your Items List</em>
          </span>
        </a>
        <a href="javascript:void(0)" class="checkout-steps__item">
          <span class="checkout-steps__item-number">03</span>
          <span class="checkout-steps__item-title">
            <span>Confirmation</span>
            <em>Review And Submit Your Order</em>
          </span>
        </a>
      </div>
      <div class="shopping-cart">
       @if ($items->count() > 0)
       <div class="cart-table__wrapper">
        <table class="cart-table">
          <thead>
            <tr>
              <th>Product</th>
              <th></th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Subtotal</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
           @foreach ($items as $item)
           <tr>
            <td>
              <div class="shopping-cart__product-item">
                <img loading="lazy" src="{{ $item->model->image }}" width="120" height="120" alt="" />
              </div>
            </td>
            <td>
              <div class="shopping-cart__product-item__detail">
                <h4>{{ $item->name ?? '' }}</h4>
                {{-- <ul class="shopping-cart__product-item__options">
                  <li>Color: Yellow</li>
                  <li>Size: L</li>
                </ul> --}}
              </div>
            </td>
            <td>
              <span class="shopping-cart__product-price">${{ $item->price}}</span>
            </td>
            <td>
              <div class="qty-control position-relative">
                <input type="number" name="quantity" value="{{ $item->qty}}" min="1" class="qty-control__number text-center">
                <form action="{{ route('cart.qty-decrease', ['rowId' => $item->rowId]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="qty-control__reduce">-</div>
                </form>
                <form action="{{ route('cart.qty-increase', ['rowId' => $item->rowId]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="qty-control__increase">+</div>
                </form>
                
              </div>
            </td>
            <td>
              <span class="shopping-cart__subtotal">{{ $item->subTotal()}}</span>
            </td>
            <td>
                <form action="{{ route('cart.remove', ['id' => $item->id]) }}" method="POST">
                    @csrf 
                    @method('DELETE')
                    <a href="javascript:void(0)" class="remove-cart">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                          <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                          <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                        </svg>
                      </a>
                </form>
           
            </td>
          </tr>
           @endforeach
          
          </tbody>
        </table>
        <div class="cart-table-footer">
          {{-- <form action="#" class="position-relative bg-body">
            <input class="form-control" type="text" name="coupon_code" placeholder="Coupon Code">
            <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4" type="submit"
              value="APPLY COUPON">
          </form> --}}
          <form action="{{ route('cart.clear') }}" method="POST">
            @csrf
             @method('DELETE')
            <button type="submit" class="btn btn-light">Clear Cart</button>
            </form>
          {{-- <button class="btn btn-light">UPDATE CART</button> --}}
        </div>
      </div>
      <div class="shopping-cart__totals-wrapper">
        <div class="sticky-content">
          <div class="shopping-cart__totals">
            <h3>Cart Totals</h3>
            <table class="cart-totals">
              <tbody>
                <tr>
                  <th>Subtotal</th>
                  <td>${{ Cart::instance('cart')->subtotal() }}</td>
                </tr>
                <tr>
                  <th>Shipping</th>
                  <td>
                    <div class="form-check">
                      {{-- <input class="form-check-input form-check-input_fill" type="checkbox" value=""
                        id="free_shipping"> --}}
                      <label class="form-check-label" for="free_shipping">Free shipping</label>
                    </div>
                    {{-- <div class="form-check">
                      <input class="form-check-input form-check-input_fill" type="checkbox" value="" id="flat_rate">
                      <label class="form-check-label" for="flat_rate">Flat rate: $49</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input form-check-input_fill" type="checkbox" value=""
                        id="local_pickup">
                      <label class="form-check-label" for="local_pickup">Local pickup: $8</label>
                    </div>
                    <div>Shipping to AL.</div>
                    <div>
                      <a href="#" class="menu-link menu-link_us-s">CHANGE ADDRESS</a>
                    </div> --}}
                  </td>
                </tr>
                <tr>
                  <th>VAT</th>
                  <td>${{ Cart::instance('cart')->tax() }}</td>
                </tr>
                <tr>
                  <th>Total</th>
                  <td>${{ Cart::instance('cart')->total() }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="mobile_fixed-btn_wrapper">
            <div class="button-wrapper container">
              <a href="checkout.html" class="btn btn-primary btn-checkout">PROCEED TO CHECKOUT</a>
            </div>
          </div>
        </div>
      </div>
       @else
       <div class="text-center">
        <p class="page-title">Your Cart is Empty</p>
       </div>
       @endif
      </div>
    </section>
  </main>

  @endsection
  @push('scripts')
  <script>
      $(function () {
          // Handle quantity decrease
          $(".qty-control__reduce").on("click", function (e) {
              e.preventDefault();
              let form = $(this).closest("form");
              $.ajax({
                  url: form.attr("action"),
                  method: form.find("input[name=_method]").val() || "POST",
                  data: form.serialize(),
                  success: function (response) {
                      updateCartView(response);
                  }
              });
          });
  
          // Handle quantity increase
          $(".qty-control__increase").on("click", function (e) {
              e.preventDefault();
              let form = $(this).closest("form");
              $.ajax({
                  url: form.attr("action"),
                  method: form.find("input[name=_method]").val() || "POST",
                  data: form.serialize(),
                  success: function (response) {
                      updateCartView(response);
                  }
              });
          });
  
          // Handle item removal
          $(".remove-cart").on("click", function (e) {
              e.preventDefault();
              let form = $(this).closest("form");
              $.ajax({
                  url: form.attr("action"),
                  method: form.find("input[name=_method]").val() || "POST",
                  data: form.serialize(),
                  success: function (response) {
                      updateCartView(response);
                  }
              });
          });
  
          // Function to update cart view
          function updateCartView(data) {
              // Update subtotal and totals dynamically
              $(".cart-totals").html(data.cart_totals_html); // Update cart totals section
              $(".cart-table tbody").html(data.cart_items_html); // Update cart items
          }
      });
  </script>
  @endpush
  
  {{-- @push('scripts')
  <script>
    $(function () {
        $(".qty-control__reduce").on("click", function () {
            $(this).closest("form").submit();
        });
        $(".qty-control__increase").on("click", function () {
            $(this).closest("form").submit();
        });

        $(".remove-cart").on("click", function () {
            $(this).closest("form").submit();
        });
    })
</script>
    
@endpush --}}