<?php

namespace GroceryApp\Http\Controllers\Category;

use GroceryApp\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use GroceryApp\Models\Category\Category;
use GroceryApp\Models\Category\SubCategory;
use GroceryApp\Models\Category\SubSubCategory;

class SubSubCategoryController extends Controller
{
    
    protected $redirectTo = 'category_child';

    protected $VIEW  = 'categories.category_sub_sub.view_sub_sub_category';
    protected $ADD   = 'categories.category_sub_sub.add_sub_sub_category';
    protected $EDIT  = 'categories.category_sub_sub.edit_sub_sub_category';

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
        $sub_sub_categories = SubSubCategory::with('category', 'subCategory')->get();
        $image_path = $this->getCategoryImagePathFull();
        return view($this->VIEW, compact('sub_sub_categories', 'image_path'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::with(['subCategory' => function ($q) {
            $q->where('is_active', 1);
        }])->where('is_active', 1)->get();
   
        $sub_sub_category = new SubSubCategory;
        $action = route('category_child.store');
        $method = "POST";
        $submit_text = "SUBMIT";

        return view($this->ADD, compact('categories', 'sub_sub_category', 'action', 'method', 'submit_text'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->getValidationRules());
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator, 'formError');
        }
        SubSubCategory::create([
                'category_id' => $request->category_id,  
                'sub_category_id' => $request->sub_category_id,    
                'sub_sub_category_name' => $request->sub_sub_category_name,    
                'sub_sub_category_description' => $request->sub_sub_category_description,    
                'meta_tag' => $request->meta_tag,   
                'meta_desc' => $request->meta_desc,        
                'added_by' => $this->getUserId(),
                'added_ip' => $this->getIp()
            ]);
        return redirect($this->adminPanel())->withAlert($this->getSuccess());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /*$categories = Category::with(['subCategory' => function ($q) {
            $q->where('is_active', 1);
        }])->get();*/
        $categories = Category::with('subCategory')->get();
        $sub_sub_category = SubSubCategory::find($id);
        $action = route('category_child.update', $sub_sub_category->sub_sub_category_id);
        $method = "PUT";
        $submit_text = "UPDATE";

        return view($this->EDIT, compact('categories', 'sub_sub_category', 'action', 'method', 'submit_text'));
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
        $validator = Validator::make($request->all(), $this->getValidationRules());
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator, 'formError');
        }
        $request['added_by'] = $this->getUserId();
        $request['added_ip'] = $this->getIp();

        SubSubCategory::find($id)->update($request->all());
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
        $category = SubSubCategory::find($id);
        $request['is_active'] = $this->getStatus($category->is_active);
        SubSubCategory::find($id)->update($request->all());
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
        //SubSubCategory::destroy($id);
        //return redirect($this->adminPanel())->withAlert($this->getDelete());
        return redirect($this->adminPanel());
    }

    public function getValidationRules()
    {
       return [
                'category_id' => 'required|numeric',
                'sub_category_id' => 'required|numeric',
                'sub_sub_category_name' => 'required|string|max:500',
             ]; 
    }
}
