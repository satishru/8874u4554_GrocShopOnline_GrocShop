<?php

namespace GroceryApp\Models\Category;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use GroceryApp\Models\Category\SubCategory;

class Category extends Model
{
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  protected $appends = ['image_full_path'];

	protected $table =  'category';

  /**
   * The primary key for the model.
   *
   * @var string
   */
  protected $primaryKey = 'category_id';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
  	'category_name', 'category_description', 'category_image', 'meta_tag', 'meta_desc', 'added_by','added_ip','is_active'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
  	 'added_by', 'added_ip', 'created_at','updated_at', 'deleted_at'
  ];

  public function subCategory() {
    return $this->hasMany(SubCategory::class, 'category_id');
  }

  public function getImageFullPathAttribute() {
    return url(\Config::get('constants.img.IMAGE_DIR').'/'.\Config::get('constants.img.IMAGE_CATEGORY')).'/'.$this->category_image;
  }

}
