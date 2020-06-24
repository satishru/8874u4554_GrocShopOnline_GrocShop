@extends('layouts.dashboard')

@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>CATEGORIES</h2>
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>EDIT CATEGORY</h2>
				</div>
				<div class="body">
					@include('categories.category.form')
				</div>
			</div>
		</div>
	</div>
</section>
@stop