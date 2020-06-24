<?php

namespace GroceryApp\Models\Category;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use GroceryApp\Models\Category\SubCategory;

class SubSubCategory extends Model
{
  use SoftDeletes;
  protected $dates = ['deleted_at'];

	protected $table =  'sub_sub_category';

  /**
   * The primary key for the model.
   *
   * @var string
   */
  protected $primaryKey = 'sub_sub_category_id';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
  	'category_id', 'sub_category_id', 'sub_sub_category_name', 'sub_sub_category_description', 'sub_sub_category_image', 'meta_tag', 'meta_desc', 'is_active', 'added_by','added_ip'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
  	 'added_by','added_ip','created_at','updated_at', 'deleted_at'
  ];

  public function category() {
      return $this->belongsTo(Category::class, 'category_id');
  }

  public function subCategory() {
      return $this->belongsTo(SubCategory::class, 'sub_category_id');
  }
}
