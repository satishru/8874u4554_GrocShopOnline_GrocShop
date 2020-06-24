<?php

namespace GroceryApp\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use GroceryApp\Models\Product\Product;

class Brand extends Model
{
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  protected $appends = ['image_full_path'];

  protected $table =  'brands';

  /**
   * The primary key for the model.
   *
   * @var string
   */
  protected $primaryKey = 'brand_id';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
  	'brand_name', 'brand_image', 'meta_tag', 'meta_desc', 'added_by', 'added_ip', 'is_active'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
     'meta_tag', 'meta_desc', 'added_by','added_ip','created_at','updated_at', 'deleted_at'
  ];

  public function brand() {
      return $this->belongsTo(Product::class, 'unit_id');
  }

  public function getImageFullPathAttribute() {
    return url(\Config::get('constants.img.IMAGE_DIR').'/'.\Config::get('constants.img.IMAGE_BRAND')).'/'.$this->brand_image;
  }
  
}
