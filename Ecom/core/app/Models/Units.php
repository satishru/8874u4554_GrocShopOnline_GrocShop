<?php

namespace GroceryApp\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use GroceryApp\Models\Product\ProductQuantity;

class Units extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table =  'units';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'unit_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unit_name', 'added_by', 'added_ip', 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'added_by', 'added_ip', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function unit()
    {
        return $this->belongsTo(ProductQuantity::class, 'unit_id');
    }
}
