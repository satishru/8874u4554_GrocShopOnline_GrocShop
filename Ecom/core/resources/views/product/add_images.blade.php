@extends('layouts.dashboard')

@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>PRODUCT IMAGES</h2>
		</div>

	  @include('layouts.data_alert')

	  <span id="call_result"></span>

		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header font-bold">
						<h2>
							ADD PRODUCT IMAGES <a class="font-12 col-cyan" href="{{ route('product.index') }}">  Go To Products</a>	
						</h2>
					</div>
					<div class="body">
						<form class="form_validation" method="POST" enctype="multipart/form-data" action={{ $action }}>
							@if( !empty($method) && in_array($method, ["PUT", "PATCH", "DELETE"]) )
        				{{ method_field($method) }} 
    					@endif
							{{ csrf_field() }}
							<div class="row clearfix">
								<div class="col-sm-6">
									<div class="form-group form-float">
										<div class="form-line {{ $errors->formError->has('product_other_images') ? ' focused error' : '' }}">
											<input type="file" multiple name="product_other_images[]" id="product_other_images" accept='image/*' required>
										</div>
										<div class="help-info">Additional Images<span class="col-pink">*</span></div>
										@if ($errors->formError->has('product_other_images'))
										<label class="error" for="product_other_images">{{ $errors->formError->first('product_other_images') }}</label>
										@endif
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
											<button class="btn bg-green waves-effect" type="submit">Submit</button>
									</div>
								</div>
							</div>
					  </form>

          </div>
				</div>
			</div>
		</div>
	</div>
</section>
@stop