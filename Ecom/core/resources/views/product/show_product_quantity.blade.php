@extends('layouts.dashboard')

@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>PRODUCT VARIENTS</h2>
		</div>

	  @include('layouts.data_alert')

	  <span id="call_result"></span>

		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header font-bold">
						<h2>
							PRODUCT VARIENTS <a class="font-12 col-cyan" href="{{ route('product.index') }}">  Go To Products</a>	
						</h2>
					</div>

					<div class="body">
						@include('layouts.loader')

						<form id="quantity_add_form" class="form_validation" method="POST" action={{ $action }}>
							<div class="row clearfix">
								<div class="col-sm-12">
									 {{ csrf_field() }}
									 @include('product.quantity_add_form')
									<div class="pull-right m-r-60">
										<div class="form-group">
											<button class="btn bg-green waves-effect" type="submit" name="submit_quantity_btn" id="submit_quantity_btn">Submit</button>
										</div>
									</div>
								</div>
							</div>
					  </form>

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
														@if($product_quantity->items_multiplier > 1)
														{{ $product_quantity->items_multiplier }} x
														@endif
														{{ $product_quantity->product_quantity }} {{ $product_quantity->unit->unit_name }}
													</td>
													<td>{{ $product_quantity->product_price }}</td>
													<td>{{ $product_quantity->product_offer_percent }}</td>
													<td>
														{!! Utils::getStatus($product_quantity->is_active) !!}
														{!! Utils::getInStockStatus($product_quantity->in_stock) !!}
													</td>
													<td>
														{!! 
													  	Utils::getBlockButton(route('product.updateProductQuantityStatus', $product_quantity->quantity_id), $product_quantity->is_active)
													  !!}
													  {!! 
													  	Utils::getInStockButton(route('product.updateProductQuantityInStockStatus', $product_quantity->quantity_id), $product_quantity->in_stock)
													  !!}
													</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
            	</div>
            </div>
            <!-- Product Variants Starts -->
            
          </div>
				</div>
			</div>
		</div>
	</div>
</section>
@stop

@section('scripts')
  <script src="{{ asset('assets/admin/js/product.js') }}"></script>
@stop