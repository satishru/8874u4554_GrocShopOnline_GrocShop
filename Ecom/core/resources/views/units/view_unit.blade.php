@extends('layouts.dashboard')

@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>UNITS</h2>
		</div>

	  @include('layouts.data_alert')

		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>UNITS</h2>
						<ul class="header-dropdown m-r--5">
							<li>
								<a class="btn bg-green waves-effect" href="{{ route('unit.create') }}">Add Unit</a>
							</li>
						</ul>
					</div>
					<div class="body table-responsive">
						<table class="table table-bordered table-hover js-basic-example dataTable">
							<thead>
								<tr>
									<th>Sl No</th>
									<th>Unit Name</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@if($units)
									@foreach($units as $indexKey => $unit)
									<tr>
										<td>{{ $indexKey+1 }}</td>
										<td>{{ $unit->unit_name }}</td>
										<td>
											{!! Utils::getStatus($unit->is_active) !!} 
										</td>
										<td>
											<form method="POST" action="">
											  {!! 
											  	Utils::getFomEditAndBlockButtons(route('unit.edit', $unit->unit_id), route('unit.updateStatus', $unit->unit_id), $unit->is_active)
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