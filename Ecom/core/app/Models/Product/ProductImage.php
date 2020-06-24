<?php

namespace GroceryApp\Models\Product;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use GroceryApp\Models\Product\Product;

class ProductImage extends Model
{
  //use SoftDeletes;
  //protected $dates = ['deleted_at'];
  protected $appends = ['image_full_path'];

	protected $table = 'product_images';

  /**
   * The primary key for the model.
   *
   * @var string
   */
  protected $primaryKey = 'image_id';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
  	'product_id', 'product_image', 'added_by', 'added_ip', 'is_active'
  ];

  /**
   * The attributes that should be hidden for arrays.
   * //, 'deleted_at'
   * @var array
   */
  protected $hidden = [
  	'added_by', 'added_ip', 'created_at', 'updated_at'
  ];

  public function productImages() {
      return $this->belongsTo(Product::class, 'product_id');
  }

  public function getImageFullPathAttribute() {
    return url(\Config::get('constants.img.IMAGE_DIR').'/'.\Config::get('constants.img.IMAGE_PRODUCT')).'/'.$this->product_image;
  }
  
}
