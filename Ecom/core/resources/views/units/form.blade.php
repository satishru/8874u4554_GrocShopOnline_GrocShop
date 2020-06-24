<form class="form_validation" method="POST" action={{ $action }}>
    @if( !empty($method) && in_array($method, ["PUT", "PATCH", "DELETE"]) )
        {{ method_field($method) }} 
    @endif
	{{ csrf_field() }}
	
	<div class="row clearfix">
		<div class="col-md-6">
			<div class="form-group form-float">
				<div class="form-line {{ $errors->formError->has('unit_name') ? ' focused error' : '' }}">
					<input type="text" class="form-control" name="unit_name" value="{{ old('unit_name' , $unit->unit_name) }}" required>
					<label class="form-label">Unit Name<span class="text-danger">*</span></label>
				</div>
				@if ($errors->formError->has('unit_name'))
				<label class="error" for="unit_name">{{ $errors->formError->first('unit_name') }}</label>
				@endif
			</div>
		</div>
	</div>

	<button class="btn bg-green waves-effect" type="submit"> {{ $submit_text }} </button>
</form>