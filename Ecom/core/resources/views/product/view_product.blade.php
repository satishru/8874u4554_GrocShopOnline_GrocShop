@extends('layouts.dashboard')

@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>PRODUCTS</h2>
		</div>

	  @include('layouts.data_alert')

		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>PRODUCTS</h2>
						<ul class="header-dropdown m-r--5">
							<li>
								<a class="btn bg-green waves-effect" href="{{ route('product.create') }}">Add Product</a>
							</li>
						</ul>
					</div>
					<div class="body table-responsive">
						<table class="table table-bordered table-hover js-basic-example dataTable">
							<thead>
								<tr>
									<th>Sl No</th>
									<th>Product</th>
									<th>Category</th>
									<th>Variants</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@if($products)
									@foreach($products as $indexKey => $product)
									<tr>
										<td>{{ $indexKey+1 }}</td>
										<td style="max-width:120px;">
											<div class="media">
												<div class="media-left">
													<a href="{{ $image_path.$product->product_image }}" target="_blank">
														<img class="media-object" src="{{ $image_path.$product->product_image }}" alt="{{ $product->product_image }}" width="64" height="64">
													</a>
												</div>
												<br/>
												<a class="col-cyan font-12 waves-effect waves-light" href="{{ route('product.show', $product->product_id) }}">{{ $product->product_name }}
												</a>
												<br/>
												<a class="col-cyan font-12 waves-effect waves-light" href="{{ route('product.addProductImages', $product->product_id) }}">
												  <span class="col-green">({{ count($product->productImages) }})</span>  Add Images
											  </a>
											</div>
										</td>
										<td>
											{{ $product->category->category_name }} <span class="font-12 col-cyan"> >> </span><br/>
											{{ $product->subCategory->sub_category_name }} <span class="font-12 col-cyan"> >> </span><br/>
											{{ $product->subSubCategory->sub_sub_category_name }}
										</td>
										<td>
											@foreach($product->productQuantity as $product_quantity)
												<span class="label bg-grey font-bold">
													@if($product_quantity->items_multiplier > 1)
													{{ $product_quantity->items_multiplier }} x
													@endif
													{{ $product_quantity->product_quantity }}<span class="font-12"> {{ $product_quantity->unit->unit_name }}</span>,
													Rs. {{ $product_quantity->product_price }} <span class="font-12">({{ $product_quantity->product_offer_percent }}%off)</span>
													<span class="{{ ($product_quantity->is_active == 1) ? 'col-teal' : 'col-pink'}} font-bold font-30">.</span>
													<span class="{{ ($product_quantity->in_stock == 1) ? 'col-teal' : 'col-pink'}} font-bold font-30">.</span>
													<br/>
												</span>
											@endforeach
											<br/>
											<a class="col-cyan font-12 waves-effect waves-light" href="{{ route('product.showProductQuantity', $product->product_id) }}">
													View/Add More
											</a>
									  </td>
										<td>
											{!! Utils::getStatus($product->is_active) !!} <br/>
											{!! Utils::getInStockStatus($product->in_stock) !!}
											<span class="col-blue font-12">({{ $product->items_in_stock}})</span>
										</td>
										<td>
											<form method="POST" action="">
												{!! 
											  	Utils::getFomEditAndBlockButtons(route('product.edit', $product->product_id), route('product.updateProductStatus', $product->product_id), $product->is_active)
											  !!}
											  {!! 
											  	Utils::getInStockButton(route('product.updateProductInStockStatus', $product->product_id), $product->in_stock)
											  !!}
											</form>
										</td>
									</tr>
									@endforeach
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@stop