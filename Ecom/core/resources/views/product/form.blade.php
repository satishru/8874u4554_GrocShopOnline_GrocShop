<span id="call_result"></span>

<form id="product_form" method="POST" enctype="multipart/form-data" action="{{" $action }}>
    @if( !empty($method) && in_array($method, [" PUT", "PATCH" , "DELETE" ]) ) {{ method_field($method) }} @endif
  {{ csrf_field() }} <input type="hidden" id="product_index_route" value="{{ route('product.index') }}" />
@include('layouts.loader')

<h3>Product Basic</h3>
<fieldset>
  <!-- Brand and Category Dropdown Starts -->
  <div class="row clearfix">
    <div class="col-sm-6">
      <div class="form-group">
        <select class="form-control show-tick selectPick" name="brand_id" id="brand_id" required>
          <option value="">Select Brand<span class="col-pink">*</span></option>
          @foreach($brands as $indexKey => $brand)
          <option value="{{ $brand->brand_id }}" @if ($brand->brand_id == old('brand_id', $product->brand_id))
            selected="selected" @endif >
            {{ $brand->brand_name }}
          </option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
        <select class="form-control show-tick selectPick" name="category_id" id="category_id" required>
          <option value="">Select Category<span class="col-pink">*</span></option>
          @foreach($categories as $indexKey => $category)
          <option value="{{ $category->category_id }}" @if ($category->category_id ==
            old('category_id',$product->category_id))
            selected="selected" @endif >
            {{ $category->category_name }}
          </option>
          @endforeach
        </select>
      </div>
    </div>
  </div>
  <!-- Brand and Category Dropdown Ends -->

  <!-- SubCategory and ChildCategory Dropdown Starts -->
  <div class="row clearfix">
    <div class="col-sm-6">
      <div class="form-group" id="sub_category">
        <select class="form-control show-tick selectPick selectSubCategory" name="sub_category_id" id="sub_category_id"
          required>
          <option value="">Select SubCategory<span class="col-pink">*</span></option>
          @foreach($categories as $category) @if
          ($category->category_id == old('category_id',
          $product->category_id))
          @if(isset($category->subCategory))
          @foreach($category->subCategory as $sub_category)
          <option value="{{ $sub_category->sub_category_id }}" @if ($sub_category->sub_category_id ==
            old('sub_category_id',$product->sub_category_id))
            selected="selected" @endif >
            {{ $sub_category->sub_category_name }}
          </option>
          @endforeach @endif @endif @endforeach
        </select>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group" id="sub_sub_category">
        <select class="form-control show-tick selectPick selectSubSubCategory" name="sub_sub_category_id"
          id="sub_sub_category_id" required>
          <option value="">Select Child Category<span class="col-pink">*</span></option>
          @foreach($categories as $category) @if
          ($category->category_id == old('category_id',
          $product->category_id))
          @if(isset($category->subCategory))
          @foreach($category->subCategory as $sub_category) @if
          ($sub_category->sub_category_id ==
          old('sub_category_id',$product->sub_category_id))
          @if(isset($sub_category->subSubCategory))
          @foreach($sub_category->subSubCategory as
          $sub_sub_category)
          <option value="{{ $sub_sub_category->sub_sub_category_id }}" @if ($sub_sub_category->sub_sub_category_id ==
            old('sub_sub_category_id',$product->sub_sub_category_id))
            selected="selected" @endif >
            {{ $sub_sub_category->sub_sub_category_name }}
          </option>
          @endforeach @endif @endif @endforeach @endif @endif
          @endforeach
        </select> @if ($errors->formError->has('sub_sub_category_id'))
        <label class="error" for="sub_sub_category_id">{{ $errors->formError->first('sub_sub_category_id') }}</label>
        @endif
      </div>
    </div>
  </div>
  <!-- Brand and Category Dropdown Ends -->

  <!-- Product Name / In Stock Starts -->
  <div class="row clearfix">
    <div class="col-sm-6">
      <div class="form-group form-float">
        <div class="form-line {{ $errors->formError->has('product_name') ? ' focused error' : '' }}">
          <input type="text" class="form-control" name="product_name"
            value="{{ old('product_name' , $product->product_name) }}" required />
          <label class="form-label">Product Name<span class="col-pink">*</span></label>
        </div>
        @if ($errors->formError->has('product_name'))
        <label class="error" for="product_name">{{ $errors->formError->first('product_name') }}</label>
        @endif
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group form-float">
        <div class="form-line">
          <input min="0" type="number" class="form-control" name="items_in_stock"
            value="{{ old('items_in_stock' , $product->items_in_stock) }}" required />
          <label class="form-label">Items In Stock<span class="col-pink">*</span></label>
        </div>
      </div>
    </div>
  </div>
  <!-- Product Name / In Stock Ends -->

  <!-- Product Image/In Stock/Daily essential/Top Selling Starts -->
  <div class="row clearfix">
    <div class="col-sm-6">
      <div class="form-group form-float">
        <div class="form-line {{ $errors->formError->has('product_image') ? ' focused error' : '' }}">
          <input type="file" name="product_image" id="product_image" accept='image/*'
            {{ !empty($is_edit) ? "" : "required" }}>
        </div>
        <div class="help-info">
          Product Image<span class="col-pink">{{
                            !empty($is_edit) ? "" : "*"
                        }}</span>
        </div>
        @if ($errors->formError->has('product_image'))
        <label class="error" for="product_image">{{ $errors->formError->first('product_image') }}</label>
        @endif
      </div>
    </div>
    <div class="col-sm-2">
      <div class="form-group">
        <input type="checkbox" name="in_stock" id="in_stock" class="filled-in" {{
                        (empty($product-
                    />in_stock) || $product->in_stock == 1) ? 'checked' : '' }}>
        <label for="in_stock">In Stock</label>
      </div>
    </div>
    <div class="col-sm-2">
      <div class="form-group">
        <input type="checkbox" name="is_daily_essential" id="is_daily_essential" class="filled-in"
          {{ (!empty($product- />is_daily_essential) && $product->is_daily_essential == 1) ? 'checked' : '' }}>
        <label for="is_daily_essential">Daily Essential</label>
      </div>
    </div>
    <div class="col-sm-2">
      <div class="form-group">
        <input type="checkbox" name="is_top_selling" id="is_top_selling" class="filled-in"
          {{ (!empty($product- />is_top_selling) && $product->is_top_selling == 1) ? 'checked' : '' }}>
        <label for="is_top_selling">Top Selling</label>
      </div>
    </div>
  </div>
  <!-- Product Image/In Stock/Daily essential/Top Selling Ends -->
</fieldset>

<h3>Product Variants</h3>
<fieldset>
  @if(isset($is_edit)) @include('product.quantity_edit_form') @else @include('product.quantity_add_form') @endif
</fieldset>

<h3>Product Other Info</h3>
<fieldset>
  <!-- Product Additional Image/ Description/ Other info Starts -->
  <div class="row clearfix">
    <div class="col-sm-12">
      <div class="form-group form-float">
        @if(isset($is_edit)) @else
        <div class="form-line {{ $errors->formError->has('product_other_images') ? ' focused error' : '' }}">
          <input type="file" multiple name="product_other_images[]" id="product_other_images" accept="image/*" />
        </div>
        <div class="help-info">Additional Images(If any)</div>
        @if ($errors->formError->has('product_other_images'))
        <label class="error" for="product_other_images">{{ $errors->formError->first('product_other_images') }}</label>
        @endif @endif
      </div>
    </div>
  </div>

  <div class="row clearfix">
    <div class="col-md-6">
      <div class="form-group form-float">
        <div class="form-line focused {{ $errors->formError->has('product_description') ? ' focused error' : '' }}">
          <br />
          <textarea class="form-control tinymce" name="product_description" id="product_description"
            required>{{ old('product_description', $product->product_description) }}</textarea>
          <label class="form-label" for="product_description">Product Description<span class="col-pink">*</span></label>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group form-float">
        <div class="form-line focused{{ $errors->formError->has('product_description') ? ' focused error' : '' }}">
          <br />
          <textarea name="product_other_description"
            class="form-control tinymce">{{ old('product_description', $product->product_description) }}</textarea>
          <label class="form-label">Product Other Info</label>
        </div>
      </div>
    </div>
  </div>

  <div class="row clearfix">
    <div class="col-md-6">
      <div class="form-group form-float">
        <div class="form-line">
          <input type="text" class="form-control" name="meta_tag" value="{{ old('meta_tag' , $product->meta_tag) }}" />
          <label class="form-label">Meta Key</label>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group form-float">
        <div class="form-line">
          <input type="text" class="form-control" name="meta_desc"
            value="{{ old('meta_desc' , $product->meta_desc) }}" />
          <label class="form-label">Meta Description</label>
        </div>
      </div>
    </div>
  </div>

  <div class="row clearfix">
    <div class="col-md-12 pull-right">
      <div class="form-group form-float">
        @if(isset($is_edit))
        <button class="btn bg-green waves-effect" type="submit" name="update_btn" id="update_btn">
          {{ $submit_text }}
        </button> @else
        <button class="btn bg-green waves-effect" type="submit" name="submit_btn" id="submit_btn">
          {{ $submit_text }}
        </button> @endif
      </div>
    </div>
  </div>
  <!-- Product Additional Image/ Description/ Other info Ends -->
</fieldset>
</form>

@section('scripts')
<script src="{{ asset('assets/admin/js/product.js') }}"></script>

<script type="text/javascript">
  $(document).ready(function() {

        var CATEGORY_DATA = @json($categories);

        $('#category_id').change(function() {
            var selected_category_id = $(this).val();

            var sub_category_options = '<option value="">Select Sub Category<span class="col-pink">*</span></option>';

            var sub_sub_category_options = '<option value="">Select Child Category<span class="col-pink">*</span></option>';

            var html_input_child = '<select class="form-control show-tick selectPick selectSubSubCategory" name="sub_sub_category_id" id="sub_sub_category_id" required>' +
                sub_sub_category_options +
                '</select>'

            if (CATEGORY_DATA != null) {
                jQuery.each(CATEGORY_DATA, function(index, category) {
                    if (selected_category_id == category.category_id && category.sub_category != null) {
                        jQuery.each(category.sub_category, function(indexKey, sub_category) {
                            sub_category_options += '<option value="' + sub_category.sub_category_id + '">' + sub_category.sub_category_name + '</option> ';
                        });
                    }
                });
            }
            html_input = '<select class="form-control show-tick selectPick selectSubCategory" name="sub_category_id" id="sub_category_id" required>' +
                sub_category_options +
                '</select>'
            $('#sub_category').html(html_input);
            $('#sub_sub_category').html(html_input_child);

            $('.selectSubCategory').selectpicker('refresh');
            $('.selectSubSubCategory').selectpicker('refresh');
        });

        $("#sub_category").on('change', 'select', function() {
            var selected_category_id = $('#category_id').val();
            var selected_sub_category_id = $(this).val();
            console.log("selected_sub_category_id");

            var sub_sub_category_options = '<option value="">Select Child Category<span class="col-pink">*</span></option>';
            if (CATEGORY_DATA != null) {
                jQuery.each(CATEGORY_DATA, function(index, category) {
                    if (selected_category_id == category.category_id && category.sub_category != null) {
                        jQuery.each(category.sub_category, function(indexKey, sub_category) {
                            if (selected_sub_category_id == sub_category.sub_category_id && sub_category.sub_sub_category != null) {
                                jQuery.each(sub_category.sub_sub_category, function(indexKey2, sub_sub_category) {
                                    sub_sub_category_options += '<option value="' + sub_sub_category.sub_sub_category_id + '">' + sub_sub_category.sub_sub_category_name + '</option> ';
                                });
                            }
                        });
                    }
                });
            }
            html_input = '<select class="form-control show-tick selectPick selectSubSubCategory" name="sub_sub_category_id" id="sub_sub_category_id" required>' +
                sub_sub_category_options +
                '</select>'
            $('#sub_sub_category').html(html_input);
            $('.selectSubSubCategory').selectpicker('refresh');
        });

    });
</script>
@stop
