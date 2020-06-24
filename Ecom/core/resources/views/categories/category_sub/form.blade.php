<form class="form_validation" method="POST" enctype="multipart/form-data" action={{ $action }}>
    @if( !empty($method) && in_array($method, ["PUT", "PATCH", "DELETE"]) )
        {{ method_field($method) }} 
    @endif
	{{ csrf_field() }}

	<div class="row clearfix">
		<div class="col-sm-6">
			<div class="form-group">
				<select class="form-control show-tick selectPick" name="category_id" required>
					<option value="">Select Category<span class="text-danger">*</span></option>
					@foreach($categories as $indexKey => $category)
					<option value="{{ $category->category_id }}"
						@if ($category->category_id == old('category_id',$sub_category->category_id))
					    selected="selected"
					  @endif
						>
						{{ $category->category_name }}
					</option> 
					@endforeach 
				</select>
				@if ($errors->formError->has('category_id'))
				  <label class="error" for="category_id">{{ $errors->formError->first('category_id') }}</label>
				@endif
			</div>
		</div>
	</div>

	<div class="row clearfix">
		<div class="col-md-6">
			<div class="form-group form-float">
				<div class="form-line {{ $errors->formError->has('sub_category_name') ? ' focused error' : '' }}">
					<input type="text" class="form-control" name="sub_category_name" value="{{ old('sub_category_name' , $sub_category->sub_category_name) }}" required>
					<label class="form-label">Sub Category Name<span class="text-danger">*</span></label>
				</div>
				@if ($errors->formError->has('sub_category_name'))
				<label class="error" for="sub_category_name">{{ $errors->formError->first('sub_category_name') }}</label>
				@endif
			</div>
		</div>
	</div>

	<div class="row clearfix">
		<div class="col-md-6">
			<div class="form-group form-float">
				<div class="form-line">
					<textarea name="sub_category_description" cols="10" rows="3" class="form-control no-resize">{{ old('sub_category_description', $sub_category->sub_category_description) }}</textarea>
					<label class="form-label">Sub Category Description</label>
				</div>
			</div>
		</div>
	</div>

	<div class="row clearfix">
		<div class="col-sm-6">
			<div class="form-group form-float">
				<div class="form-line {{ $errors->formError->has('sub_category_image') ? ' focused error' : '' }}">
					<input type="file" name="sub_category_image" id="sub_category_image" accept='image/*' 
					{{ !empty($is_edit) ? '' : 'required' }} accept="image/*" onchange="loadFile(event)">
				</div>
				<div class="help-info">Sub Category Image<span class="text-danger">{{ !empty($is_edit) ? '' : '*' }}</span>
				</div>
				@if ($errors->formError->has('sub_category_image'))
				<label class="error" for="sub_category_image">{{ $errors->formError->first('sub_category_image') }}</label>
				@endif
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-line">
				@if(isset($image_path))
				<img src="{{ $image_path.$sub_category->sub_category_image}}" alt="{{ $sub_category->sub_category_image}}"  width="50" height="50" id="image_uploaded"/>
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
					<input type="text" class="form-control" name="meta_tag" value="{{ old('meta_tag' , $sub_category->meta_tag) }}">
					<label class="form-label">Meta Key</label>
				</div>
			</div>
		</div>
	</div>

	<div class="row clearfix">
		<div class="col-md-6">
			<div class="form-group form-float">
				<div class="form-line">
					<input type="text" class="form-control" name="meta_desc" value="{{ old('meta_desc' , $sub_category->meta_desc) }}">
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