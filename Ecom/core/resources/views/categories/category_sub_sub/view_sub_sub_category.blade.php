@extends('layouts.dashboard')

@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>CHILD CATEGORIES</h2>
		</div>

	  @include('layouts.data_alert')

		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>CHILD CATEGORIES</h2>
						<ul class="header-dropdown m-r--5">
							<li>
								<a class="btn bg-green waves-effect" href="{{ route('category_child.create') }}">Add Child Category</a>
							</li>
						</ul>
					</div>
					<div class="body table-responsive">
						<table class="table table-bordered table-hover js-basic-example dataTable">
							<thead>
								<tr>
									<th>Sl No</th>
									<th>Child Category</th>
									<th>Sub Category</th>
									<th>Parent Category</th>
									<th>Description</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@if($sub_sub_categories)
									@foreach($sub_sub_categories as $indexKey => $sub_sub_category)
									<tr>
										<td>{{ $indexKey+1 }}</td>
										<td>{{ $sub_sub_category->sub_sub_category_name }}</td>
										<td>{{ $sub_sub_category->subCategory->sub_category_name }}</td>
										<td>{{ $sub_sub_category->category->category_name }}</td>
										<td>{{ $sub_sub_category->sub_sub_category_description }}</td>
										<td>
											{!! Utils::getStatus($sub_sub_category->is_active) !!} 
										</td>
										<td>
											<form method="POST" action="">
											  {!! 
											  	Utils::getFomEditAndBlockButtons(route('category_child.edit', $sub_sub_category->sub_sub_category_id), route('category_child.updateStatus', $sub_sub_category->sub_sub_category_id), $sub_sub_category->is_active)
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