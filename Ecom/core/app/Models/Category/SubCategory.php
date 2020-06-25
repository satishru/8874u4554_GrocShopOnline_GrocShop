<?php

namespace GroceryApp\Models\Category;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use GroceryApp\Models\Category\Category;
use GroceryApp\Models\Category\SubSubCategory;

use Illuminate\Support\Facades\Config;

class SubCategory extends Model
{
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  protected $appends = ['image_full_path'];

	protected $table =  'sub_category';

  /**
   * The primary key for the model.
   *
   * @var string
   */
  protected $primaryKey = 'sub_category_id';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
  	'category_id', 'sub_category_name', 'sub_category_description', 'sub_category_image', 'is_active',
    'meta_tag', 'meta_desc', 'added_by','added_ip'
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

  public function subSubCategory() {
    return $this->hasMany(SubSubCategory::class, 'sub_category_id');
  }

  public function getImageFullPathAttribute() {
    return url(Config::get('constants.img.IMAGE_DIR').'/'.Config::get('constants.img.IMAGE_CATEGORY')).'/'.$this->sub_category_image;
  }

}
