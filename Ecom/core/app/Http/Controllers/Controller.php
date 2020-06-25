<?php

namespace GroceryApp\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\File;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $ADMIN_PANEL    = 'admin-panel/';

    protected function deleteFile($path, $imageName) {
        try {
            File::delete($path.'/'.$imageName);
        } catch (\Exception $exception) {
        }
    }

    protected function getJson($arrayData) {
        return response()->json($arrayData);
    }

    protected function getApiJson($arrayData) {
        return response()->json($arrayData);
    }

    protected function getUserId() {
         return Auth::user()->id;
    }

    protected function getStatus($status) {
         return ($status == 0) ? 1 : 0;
    }

    protected function getInStockStatus($status) {
        return ($status == 0) ? 1 : 0;
    }

    protected function getIp() {
    	 return "1.0.0.0";//$request->ip();//Request::ip();
    }

    protected function generateApiToken() {
    	 return str_random(60);
    }

    protected function getSAdminType() {
    	 return Config::get('constants.user_role.SADMIN');
    }

    protected function getSignUpType() {
    	 return Config::get('constants.registered_type.SIGN_UP');
    }

    /**
     * Get the Success/Edit/Delete messages
     */
    protected function getSuccess() {
         return Config::get('constants.msg.add_success');
    }

    protected function getUpdate() {
         return Config::get('constants.msg.edit_success');
    }

    protected function getDelete() {
         return Config::get('constants.msg.delete_success');
    }

    /**
     * Get the admin panel path url
     */
    protected function adminPanelPath($redirectTo) {
         return $this->ADMIN_PANEL.$redirectTo;
    }

    /**
     * Get the Image directory for Brands, Category, Products
     */
    protected function getImageName() {
        return str_random(10).'_'.time();
    }

    protected function getBrandImagePath() {
        return public_path(Config::get('constants.img.IMAGE_BRAND'));
    }

    protected function getCategoryImagePath() {
        return public_path(Config::get('constants.img.IMAGE_CATEGORY'));
    }

    protected function getProductImagePath() {
        return public_path(Config::get('constants.img.IMAGE_PRODUCT'));
    }

    protected function getBrandImagePathFull() {
        return url($this->getImageDir().'/'.Config::get('constants.img.IMAGE_BRAND')).'/';
    }

    protected function getCategoryImagePathFull() {
        return url($this->getImageDir().'/'.Config::get('constants.img.IMAGE_CATEGORY')).'/';
    }

    protected function getProductImagePathFull() {
        return url($this->getImageDir().'/'.Config::get('constants.img.IMAGE_PRODUCT')).'/';
    }

    protected function getImageDir() {
        return Config::get('constants.img.IMAGE_DIR');
    }

    protected function getErrorArray($error_code, $error_message = "Something went wrong", $error_info = []) {
        $errorData['error_code'] = $error_code;
        $errorData['error_message'] = $error_message;
        $errorData['error_info'] = $error_info;
        return $errorData;
    }
}
