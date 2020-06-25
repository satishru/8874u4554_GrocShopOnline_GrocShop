<?php

namespace GroceryApp\Models\Utils;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Config;

class Utils
{
    public static function getStatus($status)
    {
        if ($status == 1) {
            return Config::get('constants.active');
        }
        return Config::get('constants.block');
    }

    public static function getStatusIcon($status)
    {
        if ($status == 1) {
            return 'lock_outline';
        }
        return 'lock_open';
    }

    public static function getStatusText($status)
    {
        if ($status == 1) {
            return 'Block';
        }
        return 'Active';
    }

    public static function getInStockStatus($status)
    {
        if ($status == 1) {
            return Config::get('constants.in_stock');
        }
        return Config::get('constants.out_of_stock');
    }

    public static function getInStockStatusText($status)
    {
        if ($status == 1) {
            return 'Out of stock';
        }
        return 'In stock';
    }

    public static function getFomEditAndBlockButtons($editRoute, $blockRoute, $blockStatus)
    {
        return '<a class="btn btn-xs waves-effect" href="' . $editRoute . '" data-toggle="tooltip" data-placement="top" title="Edit Item">
								<i class="material-icons col-cyan">mode_edit</i>
							 </a>
							 <a class="btn btn-xs waves-effect" href="' . $blockRoute . '" data-toggle="tooltip" data-placement="top" title="Block / UnBlock">
								<i class="material-icons col-cyan">' . Utils::getStatusIcon($blockStatus) . '</i>
							 </a>';
    }

    public static function getInStockButton($inStockRoute, $inStock)
    {
        $bg_color = ($inStock) ? 'bg-red' : '';
        return '<a class="btn btn-xs ' . $bg_color . ' waves-effect waves-light" href="' . $inStockRoute . '"
											  	data-toggle="tooltip" data-placement="top" title="In stock / Out of Stock" >
                           <i class="material-icons">add_shopping_cart</i>
                        </a>';
    }

    public static function getBlockButton($blockRoute, $blockStatus)
    {
        return '<a class="btn btn-xs waves-effect" href="' . $blockRoute . '" data-toggle="tooltip" data-placement="top" title="Block / UnBlock">
								<i class="material-icons col-cyan">' . Utils::getStatusIcon($blockStatus) . '</i>
							 </a>';
    }

    public static function getDeleteButton($deleteRoute)
    {
        return '<a class="btn btn-xs waves-effect" href="' . $deleteRoute . '" data-toggle="tooltip" data-placement="top" title="Delete Item">
								<i class="material-icons col-pink">delete_forever</i>
							 </a>';
    }
}
