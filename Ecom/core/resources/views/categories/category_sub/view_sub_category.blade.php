@extends('layouts.dashboard')

@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>SUB CATEGORIES</h2>
		</div>

	  @include('layouts.data_alert')

		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>SUB CATEGORIES</h2>
						<ul class="header-dropdown m-r--5">
							<li>
								<a class="btn bg-green waves-effect" href="{{ route('category_sub.create') }}">Add Sub Category</a>
							</li>
						</ul>
					</div>
					<div class="body table-responsive">
						<table class="table table-bordered table-hover js-basic-example dataTable">
							<thead>
								<tr>
									<th>Sl No</th>
									<th>Sub Category</th>
									<th>Parent Category</th>
									<th>Image</th>
									<th>Description</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@if($sub_categories)
									@foreach($sub_categories as $indexKey => $sub_category)
									<tr>
										<td>{{ $indexKey+1 }}</td>
										<td>{{ $sub_category->sub_category_name }}</td>
										<td>{{ $sub_category->category->category_name }}</td>
										<td>
											<img src="{{ $image_path.$sub_category->sub_category_image }}" alt="{{ $sub_category->sub_category_image }}" width="50px" height="50px">
										</td>
										<td>{{ $sub_category->sub_category_description }}</td>
										<td>
											{!! Utils::getStatus($sub_category->is_active) !!} 
										</td>
										<td>
											<form method="POST" action="">
											  {!! 
											  	Utils::getFomEditAndBlockButtons(route('category_sub.edit', $sub_category->sub_category_id), route('category_sub.updateStatus', $sub_category->sub_category_id), $sub_category->is_active)
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