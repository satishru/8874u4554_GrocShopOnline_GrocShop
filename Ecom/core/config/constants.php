<?php

return [
    'img' => [
        'IMAGE_DIR' => 'core/public',
        'IMAGE_BRAND' => 'images/brand',
        'IMAGE_CATEGORY' => 'images/category',
        'IMAGE_PRODUCT' => 'images/product'
    ],

    'error_code' => [
        'AUTH_ERROR' => 401,
        'FIELD_ERROR' => 412,
    ],
    
    'API_KEY' => '8j977h88-294997-40tY58-93b0-22042aJ6a53d',

    'active' => '<span class="label label-success">Active</span>',
    'block' => '<span class="label label-danger">Blocked</span>',

    'in_stock' => '<span class="label label-success">In stock</span>',
    'out_of_stock' => '<span class="label label-danger">Out of stock</span>',

	// 1=SADMIN 2=ADMIN 3=USER 4=VENDOR
    'user_role' => [
        'SADMIN' => '1',
        'ADMIN'  => '2',
        'USER'   => '3',
        'VENDOR' => '4'
    ],

    // 1=SIGN_UP 2=GOOGLE 3=FACEBOOK 4=SADMIN_CREATE
    'registered_type' => [
        'SIGN_UP'       => '1',
        'GOOGLE'        => '2',
        'FACEBOOK'      => '3',
        'SADMIN_CREATE' => '4'
    ],

    'msg' => [
        'add_success'    => 'Added successfully',
        'edit_success'   => 'Updated successfully',
        'delete_success' => 'Deleted successfully'
    ]
];