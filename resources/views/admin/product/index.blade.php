@extends('layouts.admin')

@section('content')

<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>All Products</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="index.html">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">All Products</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search">
                        <fieldset class="name">
                            <input type="text" placeholder="Search here..." class="" name="name"
                                tabindex="2" value="" aria-required="true" required="">
                        </fieldset>
                        <div class="button-submit">
                            <button class="" type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
                <a class="tf-button style-1 w208" href="{{ route('admin.product-create') }}"><i
                        class="icon-plus"></i>Add new</a>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>SalePrice</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Featured</th>
                            <th>Stock</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($products as $product)
                      <tr>
                        <td>{{$loop->iteration}}</td>
                        <td class="pname">
                            <div class="image">
                                <img src="{{ $product->image }}" alt="" class="image">
                            </div>
                            <div class="name">
                                {{-- <a href="#" class="body-title-2">Product6</a> --}}
                                <div class="text-tiny mt-3 wrap" style="word-wrap: break-word; white-space: normal;">{{ $product->name }}</div>
                            </div>
                        </td>
                        <td>{{$product->sale_price}}</td>
                        <td>{{$product->sku}}</td>
                        <td class="wrap" style="word-wrap: break-word; white-space: normal;">{{$product->category->name}}</td>
                        <td class="wrap" style="word-wrap: break-word; white-space: normal;">{{$product->brand->name}}</td>
                        <td>{{$product->featured == 1 ? 'Yes' : 'No'}}</td>
                        <td class="wrap" style="word-wrap: break-word; white-space: normal;">{{$product->stock_status}}</td>
                        <td class="wrap" style="word-wrap: break-word; white-space: normal;">{{$product->quantity}}</td>
                        <td>
                            <div class="list-icon-function">
                                <a href="{{ route('admin.product-show', $product->id) }}" target="_blank">
                                    <div class="item eye">
                                        <i class="icon-eye"></i>
                                    </div>
                                </a>
                                <a href="{{ route('admin.product-edit', $product->id) }}">
                                    <div class="item edit">
                                        <i class="icon-edit-3"></i>
                                    </div>
                                </a>
                                <form action="{{ route('admin.product-destroy', $product->id) }} " method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="item text-danger delete">
                                        <i class="icon-trash-2"></i>
                                    </div>
                                </form>
                            </div>
                        </td>
                    </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>

            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">


            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    $(function () {
        $(".delete").on('click', function (e) {
            e.preventDefault();
            var form = $(this).closest('form');
            swal({
                title: "Are you sure?",
                text: "You want to delete this record!",
                type: "warning",
                buttons: ["No", "Yes"],
                dangerMode: true,
            }).then((result) => {
                if (result) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush

{{-- 
@push('scripts')
<script>
    $(function () {
        $(".delete").on('click', function (e) {
            e.preventDefault();
            var form = $(this).closest('form'); // Fixing the syntax here
            swal({
                title: "Are you sure?",
                text: "You want to delete this record!",
                icon: "warning", // SweetAlert uses 'icon' instead of 'type'
                buttons: {
                    cancel: {
                        text: "No",
                        value: false,
                        visible: true,
                        className: "btn-secondary",
                    },
                    confirm: {
                        text: "Yes",
                        value: true,
                        visible: true,
                        className: "btn-danger",
                    }
                },
            }).then((result) => {
                if (result) { // 'result' will be true if the "Yes" button is clicked
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
 --}}