<?php

namespace GroceryApp\Http\Controllers\Api;

use Illuminate\Http\Request;
use GroceryApp\Http\Controllers\Controller;

use GroceryApp\Models\Category\Category;

class CategoryApiController extends Controller
{
	/**
   * Return the Category and SubCategory and SubSubCategory from storage.
   *
   * @param  Request  $request
   * @return \Illuminate\Http\Response
   */ 
  public function getCategory(Request $request) {
    $data['category'] = Category::with([
            'subCategory' => function($q) {
                $q->where('is_active', 1);
            },
            'subCategory.subSubCategory' => function($q) {
                $q->where('is_active', 1);
            }
        ])->has('subCategory', '>' , 0)->where('is_active', 1)->get();
  	return $this->getApiJson($data);
  }

}
