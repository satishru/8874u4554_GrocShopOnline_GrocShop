<?php

namespace GroceryApp\Models\Product;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use GroceryApp\Models\Product\Product;
use GroceryApp\Models\Units;

class ProductQuantity extends Model
{
  use SoftDeletes;
  protected $dates = ['deleted_at'];
  
  protected $table =  'product_quantity';

  /**
   * The primary key for the model.
   *
   * @var string
   */
  protected $primaryKey = 'quantity_id';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */

  protected $fillable = [
  	'product_id', 'items_multiplier', 'product_quantity', 'unit_id', 'product_price', 
    'product_offer_percent', 'in_stock', 'added_by', 'added_ip', 'is_active'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
  	'added_by', 'added_ip', 'created_at', 'updated_at', 'deleted_at'
  ];

  public function productQuantity()
  {
      return $this->belongsTo(Product::class, 'product_id');
  }

  public function unit() {
    return $this->hasOne(Units::class, 'unit_id', 'unit_id');
  }
}
