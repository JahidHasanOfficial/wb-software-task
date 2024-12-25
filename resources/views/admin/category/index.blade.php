@extends('layouts.admin')

@section('content')


<style>
    .table-all-user .table img {
    max-width: 60px;
    height: auto;
    border-radius: 5px;
}
.wg-filter .form-search input {
    border-radius: 5px;
    padding: 10px;
    border: 1px solid #ddd;
    width: 100%;
    max-width: 300px;
}
.wg-filter .button-submit button {
    margin-left: 10px;
}
.wgp-pagination {
    margin-top: 15px;
}
.wgp-pagination nav {
    display: flex;
    justify-content: flex-end;
    width: 100%;
}

</style>
<div class="main-content-inner">
    <div class="main-content-wrap">
        <!-- Page Title and Breadcrumbs -->
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Brands</h3>
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
                    <div class="text-tiny">Categories</div>
                </li>
            </ul>
        </div>

        <!-- Filters and Add Button -->
        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search">
                        <fieldset class="name">
                            <input 
                                type="text" 
                                placeholder="Search here..." 
                                class="form-control" 
                                name="name"
                                tabindex="2" 
                                value="" 
                                aria-required="true" 
                                required
                            >
                        </fieldset>
                        <div class="button-submit">
                            <button class="" type="submit">
                                <i class="icon-search"></i> Search
                            </button>
                        </div>
                    </form>
                </div>
                <a class="tf-button style-1 w208 btn btn-success" href="">
                    <i class="icon-plus"></i> Add New
                </a>
            </div>

            <!-- Table -->
            <div class="wg-table table-all-user">
                <div class="table-responsive">
                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="name">{{ $category->name }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td>
                                        <div class="image">
                                            <img 
                                                src="{{ $category->image }}" 
                                                alt="Category Image" 
                                                class="img-thumbnail" 
                                                style="width: 60px; height: 60px;"
                                            >
                                        </div>
                                    </td>
                                    <td>
                                        <a 
                                            href="{{ route('admin.category-edit', ['id' => $category->id]) }}" 
                                            class="btn btn-sm btn-primary"
                                        >
                                            <i class="icon-edit"></i> Edit
                                        </a>
                                        <a 
                                            href="{{ route('admin.category-destroy', ['id' => $category->id]) }}" 
                                            class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Are you sure you want to delete this category?');"
                                        >
                                            <i class="icon-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
