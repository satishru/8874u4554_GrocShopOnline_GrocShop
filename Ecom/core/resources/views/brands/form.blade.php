<form class="form_validation" method="POST" enctype="multipart/form-data" action={{ $action }}>
	@if( !empty($method) && in_array($method, ["PUT", "PATCH", "DELETE"]) )
	{{ method_field($method) }} 
	@endif
	{{ csrf_field() }}
	
	<div class="row clearfix">
		<div class="col-md-6">
			<div class="form-group form-float">
				<div class="form-line {{ $errors->formError->has('brand_name') ? ' focused error' : '' }}">
					<input type="text" class="form-control" name="brand_name" value="{{ old('brand_name' , $brand->brand_name) }}" required>
					<label class="form-label">Brand Name<span class="text-danger">*</span></label>
				</div>
				@if ($errors->formError->has('brand_name'))
				<label class="error" for="brand_name">{{ $errors->formError->first('brand_name') }}</label>
				@endif
			</div>
		</div>
	</div>

	<div class="row clearfix">
		<div class="col-sm-6">
			<div class="form-group form-float">
				<div class="form-line {{ $errors->formError->has('brand_image') ? ' focused error' : '' }}">
					<input type="file" name="brand_image" id="brand_image" accept='image/*' 
					{{ !empty($is_edit) ? '' : 'required' }} accept="image/*" onchange="loadFile(event)">
				</div>
				<div class="help-info">Brand Image<span class="text-danger">{{ !empty($is_edit) ? '' : '*' }}</span>
				</div>
				@if ($errors->formError->has('brand_image'))
				<label class="error" for="brand_image">{{ $errors->formError->first('brand_image') }}</label>
				@endif
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-line">
				@if(isset($image_path))
				<img src="{{ $image_path.$brand->brand_image}}" alt="{{$brand->brand_name}}"  width="50" height="50" id="image_uploaded"/>
				@else
				<img src="" alt="" width="50" height="50" id="image_uploaded"/>
				@endif
			</div>
		</div>
	</div>

	<div class="row clearfix">
		<div class="col-md-6">
			<div class="form-group form-float">
				<div class="form-line">
					<input type="text" class="form-control" name="meta_tag" value="{{ old('meta_tag' , $brand->meta_tag) }}">
					<label class="form-label">Meta Key</label>
				</div>
			</div>
		</div>
	</div>

	<div class="row clearfix">
		<div class="col-md-6">
			<div class="form-group form-float">
				<div class="form-line">
					<input type="text" class="form-control" name="meta_desc" value="{{ old('meta_desc' , $brand->meta_desc) }}">
					<label class="form-label">Meta Description</label>
				</div>
			</div>
		</div>
	</div>

	<button class="btn bg-green waves-effect" type="submit"> {{ $submit_text }} </button>
</form>

@section('scripts')
  <script type="text/javascript">
	  var loadFile = function(event) {
	    var reader = new FileReader();
	    reader.onload = function(){
	      var output = document.getElementById('image_uploaded');
	      output.src = reader.result;
	    };
	    reader.readAsDataURL(event.target.files[0]);
    };
  </script>
@stop