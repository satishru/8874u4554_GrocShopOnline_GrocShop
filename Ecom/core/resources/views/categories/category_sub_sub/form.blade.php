<form class="form_validation" method="POST" enctype="multipart/form-data" action={{ $action }}>
    @if( !empty($method) && in_array($method, ["PUT", "PATCH", "DELETE"]) )
        {{ method_field($method) }}
    @endif
	{{ csrf_field() }}

	<div class="row clearfix">
		<div class="col-sm-6">
			<div class="form-group">
				<select class="form-control show-tick selectPick" name="category_id" id="category_id" required>
					<option value="">Select Category<span class="text-danger">*</span></option>
					@foreach($categories as $indexKey => $category)
					<option value="{{ $category->category_id }}"
						@if ($category->category_id == old('category_id',$sub_sub_category->category_id))
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
		<div class="col-sm-6">
			<div class="form-group" id="sub_category">
				<select class="form-control show-tick selectPick" name="sub_category_id" required>
					<option value="">Select Sub Category<span class="text-danger">*</span></option>
					@foreach($categories as $category)
						@if ($category->category_id == old('category_id', $sub_sub_category->category_id))
							@if(isset($category->subCategory))
						  	 @foreach($category->subCategory as $sub_category)
						  	  <option value="{{ $sub_category->sub_category_id }}"
										@if ($sub_category->sub_category_id == old('sub_category_id',$sub_sub_category->sub_category_id))
									    selected="selected"
									  @endif
										>
										{{ $sub_category->sub_category_name }}
									</option>
				         @endforeach
					  	@endif
						@endif
					@endforeach
				</select>
				@if ($errors->formError->has('sub_category_id'))
				  <label class="error" for="category_id">{{ $errors->formError->first('sub_category_id') }}</label>
				@endif
			</div>
		</div>
	</div>

	<div class="row clearfix">
		<div class="col-md-6">
			<div class="form-group form-float">
				<div class="form-line {{ $errors->formError->has('sub_sub_category_name') ? ' focused error' : '' }}">
					<input type="text" class="form-control" name="sub_sub_category_name" value="{{ old('sub_sub_category_name' , $sub_sub_category->sub_sub_category_name) }}" required>
					<label class="form-label">Child Category Name<span class="text-danger">*</span></label>
				</div>
				@if ($errors->formError->has('sub_sub_category_name'))
				<label class="error" for="sub_sub_category_name">{{ $errors->formError->first('sub_sub_category_name') }}</label>
				@endif
			</div>
		</div>
	</div>

	<div class="row clearfix">
		<div class="col-md-6">
			<div class="form-group form-float">
				<div class="form-line">
					<textarea name="sub_sub_category_description" cols="10" rows="3" class="form-control no-resize">{{ old('sub_sub_category_description', $sub_sub_category->sub_sub_category_description) }}</textarea>
					<label class="form-label">Child Category Description</label>
				</div>
			</div>
		</div>
	</div>

	<div class="row clearfix">
		<div class="col-md-6">
			<div class="form-group form-float">
				<div class="form-line">
					<input type="text" class="form-control" name="meta_tag" value="{{ old('meta_tag' , $sub_sub_category->meta_tag) }}">
					<label class="form-label">Meta Key</label>
				</div>
			</div>
		</div>
	</div>

	<div class="row clearfix">
		<div class="col-md-6">
			<div class="form-group form-float">
				<div class="form-line">
					<input type="text" class="form-control" name="meta_desc" value="{{ old('meta_desc' , $sub_sub_category->meta_desc) }}">
					<label class="form-label">Meta Description</label>
				</div>
			</div>
		</div>
	</div>

	<button class="btn bg-green waves-effect" type="submit"> {{ $submit_text }} </button>
</form>

@section('scripts')
  <script type="text/javascript">
	 $(document).ready(function() {

	  var CATEGORY_DATA = @json($categories);

      $('#category_id').change(function() {
          var selected_id = $(this).val();
          var sub_category_options = '<option value="">Select Sub Category<span class="text-danger">*</span></option>'

     			if(CATEGORY_DATA != null) {
     				jQuery.each(CATEGORY_DATA, function(index, category) {
     					if(selected_id == category.category_id && category.sub_category != null) {
     						jQuery.each(category.sub_category, function(indexKey, sub_category) {
     							 sub_category_options += '<option value="'+sub_category.sub_category_id+'">'+sub_category.sub_category_name+'</option> ';
     						});
     					}
						});
					}
					html_input = '<select class="form-control selectSubCategory show-tick" name="sub_category_id" id="sub_category_id" required>'
															+sub_category_options
												+'</select>'
					$('#sub_category').html(html_input);
				  $('.selectSubCategory').selectpicker('refresh');
      });

    });
  </script>
@stop
