@extends('layouts.dashboard')

@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>BRANDS</h2>
		</div>

	  @include('layouts.data_alert')

		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>BRANDS</h2>
						<ul class="header-dropdown m-r--5">
							<li>
								<a class="btn bg-green waves-effect" href="{{ route('brands.create') }}">Add Brand</a>
							</li>
						</ul>
					</div>
					<div class="body table-responsive">
						<table class="table table-bordered table-hover js-basic-example dataTable">
							<thead>
								<tr>
									<th>Sl No</th>
									<th>Brand Name</th>
									<th>Brand Image</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@if($brands)
									@foreach($brands as $indexKey => $brand)
									<tr>
										<td>{{ $indexKey+1 }}</td>
										<td>{{ $brand->brand_name }}</td>
										<td>
											<img src="{{ $image_path.$brand->brand_image }}" alt="{{$brand->brand_name}}" width="50px" height="50px">
										</td>
										<td>
											{!! Utils::getStatus($brand->is_active) !!} 
										</td>
										<td>
											<form method="POST" action="">
												{!! 
											  	Utils::getFomEditAndBlockButtons(route('brands.edit', $brand->brand_id), route('brands.updateStatus', $brand->brand_id), $brand->is_active)
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

@section('scripts')
  <script type="text/javascript">
  	function confirmDelete() {
  		return confirm("Are you sure you want to delete?");
  	}
  </script>
@stop