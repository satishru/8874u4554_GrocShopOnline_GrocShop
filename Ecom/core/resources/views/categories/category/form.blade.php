<form class="form_validation" method="POST" enctype="multipart/form-data" action={{ $action }}>
    @if( !empty($method) && in_array($method, ["PUT", "PATCH", "DELETE"]) )
        {{ method_field($method) }} 
    @endif
	{{ csrf_field() }}

	<div class="row clearfix">
		<div class="col-md-6">
			<div class="form-group form-float">
				<div class="form-line {{ $errors->formError->has('category_name') ? ' focused error' : '' }}">
					<input type="text" class="form-control" name="category_name" value="{{ old('category_name' , $category->category_name) }}" required>
					<label class="form-label">Category Name<span class="col-pink">*</span></label>
				</div>
				@if ($errors->formError->has('category_name'))
				<label class="error" for="category_name">{{ $errors->formError->first('category_name') }}</label>
				@endif
			</div>
		</div>
	</div>

	<div class="row clearfix">
		<div class="col-md-6">
			<div class="form-group form-float">
				<div class="form-line">
					<textarea name="category_description" cols="10" rows="3" class="form-control no-resize">{{ old('category_description', $category->category_description) }}</textarea>
					<label class="form-label">Category Description</label>
				</div>
			</div>
		</div>
	</div>

	<div class="row clearfix">
		<div class="col-sm-6">
			<div class="form-group form-float">
				<div class="form-line {{ $errors->formError->has('category_image') ? ' focused error' : '' }}">
					<input type="file" name="category_image" id="category_image" accept='image/*' 
					{{ !empty($is_edit) ? '' : 'required' }} accept="image/*" onchange="loadFile(event)">
				</div>
				<div class="help-info">Category Image<span class="text-danger">{{ !empty($is_edit) ? '' : '*' }}</span>
				</div>
				@if ($errors->formError->has('category_image'))
				<label class="error" for="category_image">{{ $errors->formError->first('category_image') }}</label>
				@endif
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-line">
				@if(isset($image_path))
				<img src="{{ $image_path.$category->category_image}}" alt="{{$category->category_image}}"  width="50" height="50" id="image_uploaded"/>
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
					<input type="text" class="form-control" name="meta_tag" value="{{ old('meta_tag' , $category->meta_tag) }}">
					<label class="form-label">Meta Key</label>
				</div>
			</div>
		</div>
	</div>

	<div class="row clearfix">
		<div class="col-md-6">
			<div class="form-group form-float">
				<div class="form-line">
					<input type="text" class="form-control" name="meta_desc" value="{{ old('meta_desc' , $category->meta_desc) }}">
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