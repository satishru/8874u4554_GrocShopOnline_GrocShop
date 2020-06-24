<?php

namespace GroceryApp\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use GroceryApp\Models\Brand;

class BrandController extends Controller
{
    protected $redirectTo = 'brands';

    protected $VIEW  = 'brands.view_brands';
    protected $ADD   = 'brands.add_brands';
    protected $EDIT  = 'brands.edit_brands';

    public function adminPanel() {
        return $this->adminPanelPath($this->redirectTo);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::all();
        $image_path = $this->getBrandImagePathFull();
        return view($this->VIEW, compact('brands', 'image_path'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brand  = new Brand;
        $action = route('brands.store');
        $method = "POST";
        $submit_text = "SUBMIT";

        return view($this->ADD, compact('brand', 'action', 'method', 'submit_text'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->getValidationRules(false));
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator, 'formError');
        }
        
        $image = $request->file('brand_image');
        $file_name = $this->getImageName().'.'.$image->getClientOriginalExtension();
        if($image->move($this->getBrandImagePath(), $file_name)) {
            Brand::create([
                'brand_name' => $request->brand_name, 
                'brand_image' => $file_name,
                'meta_tag' => $request->meta_tag,   
                'meta_desc' => $request->meta_desc,        
                'added_by' => $this->getUserId(),
                'added_ip' => $this->getIp()
            ]);
            return redirect($this->adminPanel())->withAlert($this->getSuccess());
        } else {
            return redirect()->back()->withInput()->ithErrors(['brand_image' => ['Image Upload failed']]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand  = Brand::find($id);
        $action = route('brands.update', $brand->brand_id);
        $method = "PUT";
        $submit_text = "UPDATE";
        $is_edit = true;
        $image_path = $this->getBrandImagePathFull();

        return view($this->EDIT, compact('brand', 'action', 'method', 'submit_text', 'is_edit', 'image_path'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->getValidationRules(true));
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator, 'formError');
        }
        $brand = Brand::find($id);
        $file_name_old = $brand->brand_image;
        $file_name = $file_name_old;

        if ($request->hasFile('brand_image')) {
            $image = $request->file('brand_image');
            $file_name_new = $this->getImageName().'.'.$image->getClientOriginalExtension();
            if($image->move($this->getBrandImagePath(), $file_name_new)) {
                $file_name = $file_name_new;
                $this->deleteFile($this->getBrandImagePath(), $file_name_old);
            }
        }
        $request = $request->all();
        $request['brand_image'] = $file_name;
        $request['added_by'] = $this->getUserId();
        $request['added_ip'] = $this->getIp();

        Brand::find($id)->update($request);
        return redirect($this->adminPanel())->withAlert($this->getUpdate());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus($id)
    {
        $request = new Request;
        $brand = Brand::find($id);
        $request['is_active'] = $this->getStatus($brand->is_active);
        Brand::find($id)->update($request->all());
        return redirect($this->adminPanel())->withAlert($this->getUpdate());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect($this->adminPanel());
    }

    public function getValidationRules($isUpdate)
    {
        if($isUpdate) {
            return [
                'brand_name' => 'required|string|max:500',
                'brand_image'=> 'nullable|image|max:1024' 
                ]; 
        } else {
            return [
                'brand_name' => 'required|string|max:500',
                'brand_image'=> 'required|image|max:1024' 
            ];
        }
    }
}
