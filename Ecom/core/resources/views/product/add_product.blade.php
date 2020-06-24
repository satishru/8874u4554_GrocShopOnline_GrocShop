@extends('layouts.dashboard')

@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>PRODUCT</h2>
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>ADD PRODUCT   <a class="font-12 col-cyan" href="{{ route('product.index') }}">  Go To Products</a>	
					</h2>
				</div>
				<div class="body">
					@include('product.form')
				</div>
			</div>
		</div>
	</div>
</section>
@stop
