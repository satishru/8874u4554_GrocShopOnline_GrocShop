<?php

namespace GroceryApp\Models\Product;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use GroceryApp\Models\Product\ProductQuantity;
use GroceryApp\Models\Product\ProductImage;

use GroceryApp\Models\Brand;

use GroceryApp\Models\Category\Category;
use GroceryApp\Models\Category\SubCategory;
use GroceryApp\Models\Category\SubSubCategory;

class Product extends Model
{
  use SoftDeletes;
  protected $dates = ['deleted_at'];

  protected $appends = ['image_full_path'];

	protected $table = 'product';

  /**
   * The primary key for the model.
   *
   * @var string
   */
  protected $primaryKey = 'product_id';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
  	'brand_id', 'category_id', 'sub_category_id', 'sub_sub_category_id', 'product_name', 'product_description', 'product_image', 'in_stock', 'items_in_stock', 'is_daily_essential', 'is_top_selling', 'meta_tag', 'meta_desc', 'added_by', 'added_ip', 'is_active'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
  	'added_by', 'added_ip', 'created_at', 'updated_at', 'deleted_at'
  ];

  public function productQuantity() {
    return $this->hasMany(ProductQuantity::class, 'product_id');
  }

  public function productImages() {
    return $this->hasMany(ProductImage::class, 'product_id');
  }

  public function category() {
      return $this->belongsTo(Category::class, 'category_id');
  }

  public function subCategory() {
      return $this->belongsTo(SubCategory::class, 'sub_category_id');
  }

  public function subSubcategory() {
      return $this->belongsTo(SubSubCategory::class, 'sub_sub_category_id');
  }

  public function brand() {
    return $this->hasOne(Brand::class, 'brand_id', 'brand_id');
  }

  public function getImageFullPathAttribute() {
    return url(\Config::get('constants.img.IMAGE_DIR').'/'.\Config::get('constants.img.IMAGE_PRODUCT')).'/'.$this->product_image;
  }

}
