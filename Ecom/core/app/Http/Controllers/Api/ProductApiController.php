<?php

namespace GroceryApp\Http\Controllers\Api;

use Illuminate\Pagination\Paginator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use GroceryApp\Http\Controllers\Controller;

use GroceryApp\Models\Category\Category;
use GroceryApp\Models\Category\SubCategory;
use GroceryApp\Models\Category\SubSubCategory;

use GroceryApp\Models\Product\Product;
use GroceryApp\Models\Product\ProductQuantity;
use GroceryApp\Models\Product\ProductImage;

class ProductApiController extends Controller
{
	/**
   * Return the Prodcuts belongs to  SubCategory & SubSubCategory from storage.
   * if sub_sub_category_id is 0 then return all products belongs to sub_category_id
   * Else compare both sub_category_id and sub_sub_category_id
   * need to send sub_sub_category_id 0 if no SubSubCategory available
   *
   * @param  Request  $request
   * @return \Illuminate\Http\Response
   */
  public function getProducts(Request $request) 
  {
  	  $rules = ['sub_category_id' => 'required|numeric', 'sub_sub_category_id' => 'required|numeric'];
      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
        $errorData = $this->getErrorArray(\Config::get('constants.error_code.FIELD_ERROR'), "Missing required fields", $validator->errors()->all());
        return $this->getApiJson($errorData);
      }

      $data['products'] = Product::with('productQuantity', 'productQuantity.unit')
        ->where("sub_category_id", $request->sub_category_id)
        ->when($request->sub_sub_category_id > 0,  function ($query) use($request) {
				   $query->where('sub_sub_category_id', $request->sub_sub_category_id);
				})
			  ->orderBy('product_id', 'DESC')->paginate(50); 

  	  return $this->getApiJson($data);
  }

  /**
   * Return the Prodcuts Details based of product id
   *
   * @param  Request  $request
   * @return \Illuminate\Http\Response
   */
  public function getProductDetail(Request $request) 
  {
  	  $rules = ['product_id' => 'required|numeric'];
      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
        $errorData = $this->getErrorArray(\Config::get('constants.error_code.FIELD_ERROR'), "Missing required fields", $validator->errors()->all());
        return $this->getApiJson($errorData);
      }

      $data['product'] = Product::with('brand','productQuantity', 'productQuantity.unit', 'productImages')->orderBy('product_id', 'DESC')->where("product_id", $request->product_id)->get();

  	  return $this->getApiJson($data);
  }

}
