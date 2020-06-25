@extends('layouts.dashboard') @section('content')
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>SHOW PRODUCT</h2>
        </div>

        @include('layouts.data_alert')

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header font-bold">
                        <h2>
                            {{ $product->product_name }}<a class="font-12 col-cyan" href="{{ route('product.index') }}">
                                Go To Products</a>
                        </h2>
                    </div>

                    <div class="body">

                        <div class="col-sm-12">
                            <div class="col-sm-3">
                                <a href="{{ $image_path.$product->product_image }}" target="_blank">
                                    <img class="img-responsive" src="{{ $image_path.$product->product_image }}">
                                </a>
                            </div>
                        </div>

                        <!-- Product Basic Info Starts -->
                        <h2 class="card-inside-title">
                            Product Info
                        </h2>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Name</th>
                                                <td>{{ $product->product_name }} </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Brand</th>
                                                <td>{{ $product->brand->brand_name }} </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Category</th>
                                                <td>
                                                    {{ $product->category->category_name }} <span class="font-12 col-cyan"> >> </span> {{ $product->subCategory->sub_category_name }} <span class="font-12 col-cyan"> >> </span> {{ $product->subSubCategory->sub_sub_category_name
                                                    }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Items in stock</th>
                                                <td>{{ $product->items_in_stock }} {!! Utils::getInStockStatus($product->in_stock) !!}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Status</th>
                                                <td>{!! Utils::getStatus($product->is_active) !!} </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Is Daily Essential</th>
                                                <td>
                                                    @if($product->is_daily_essential == 1)
                                                    <span class="col-green">Yes</span> @else
                                                    <span>No</span> @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Is Top Selling</th>
                                                <td>
                                                    @if($product->is_top_selling ==1)
                                                    <span class="col-green">Yes</span> @else
                                                    <span>No</span> @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Description</th>
                                                <td>{!! $product->product_description !!}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Product Basic Info Ends -->

                        <!-- Product Variants Starts -->
                        <h2 class="card-inside-title">
                            Product Variants
                        </h2>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <th>Sl No</th>
                                            <th>Quantity</th>
                                            <th>Price(Rs)</th>
                                            <th>Offer(%)</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            @foreach($product->productQuantity as $indexKey => $product_quantity)
                                            <tr>
                                                <td>{{ $indexKey+1 }}</td>
                                                <td>
                                                    @if($product_quantity->items_multiplier > 1) {{ $product_quantity->items_multiplier }} x @endif {{ $product_quantity->product_quantity }} {{ $product_quantity->unit->unit_name }}
                                                </td>
                                                <td>{{ $product_quantity->product_price }}</td>
                                                <td>{{ $product_quantity->product_offer_percent }}</td>
                                                <td>
                                                    {!! Utils::getStatus($product_quantity->is_active) !!} {!! Utils::getInStockStatus($product_quantity->in_stock) !!}
                                                </td>
                                                <td>
                                                    {!! Utils::getBlockButton(route('product.updateProductQuantityStatus', $product_quantity->quantity_id), $product_quantity->is_active) !!} {!! Utils::getInStockButton(route('product.updateProductQuantityInStockStatus', $product_quantity->quantity_id),
                                                    $product_quantity->in_stock) !!}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Product Variants Starts -->

                        <!-- Product Other Images Starts -->
                        <h2 class="card-inside-title">
                            Product Other Images
                        </h2>
                        <div class="row clearfix">
                            <div class="col-sm-6">

                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <th>Sl No</th>
                                            <th>Image</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            @foreach($product->productImages as $indexKey => $product_other_image)
                                            <tr>
                                                <td>{{ $indexKey+1 }}</td>
                                                <td>
                                                    <a href="{{ $image_path.$product_other_image->product_image }}" target="_blank">
                                                        <img src="{{ $image_path.$product_other_image->product_image }}"
                                                            width="120" height="80">
                                                    </a>
                                                </td>
                                                <td>
                                                    <br /> {!! Utils::getDeleteButton(route('product.destroyProductOtherImage', $product_other_image->image_id)) !!}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Product Other Images Ends -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop