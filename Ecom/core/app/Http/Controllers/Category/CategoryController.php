<?php

namespace GroceryApp\Http\Controllers\Category;

use GroceryApp\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use GroceryApp\Models\Category\Category;

class CategoryController extends Controller
{
    protected $redirectTo = 'category';

    protected $VIEW  = 'categories.category.view_category';
    protected $ADD   = 'categories.category.add_category';
    protected $EDIT  = 'categories.category.edit_category';

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
        $categories = Category::all();
        $image_path = $this->getCategoryImagePathFull();
        return view($this->VIEW, compact('categories', 'image_path'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new Category;
        $action = route('category.store');
        $method = "POST";
        $submit_text = "SUBMIT";

        return view($this->ADD, compact('category', 'action', 'method', 'submit_text'));
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
        $image = $request->file('category_image');
        $file_name = $this->getImageName().'.'.$image->getClientOriginalExtension();
        if($image->move($this->getCategoryImagePath(), $file_name)) {
            Category::create([
                'category_name' => $request->category_name,    
                'category_description' => $request->category_description,    
                'category_image' => $file_name,
                'meta_tag' => $request->meta_tag,   
                'meta_desc' => $request->meta_desc,        
                'added_by' => $this->getUserId(),
                'added_ip' => $this->getIp()
            ]);
            return redirect($this->adminPanel())->withAlert($this->getSuccess());
        } else {
            return redirect()->back()->withInput()->withErrors(['category_image' => ['Image Upload failed']]);
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
        $category = Category::find($id);
        $action = route('category.update', $category->category_id);
        $method = "PUT";
        $submit_text = "UPDATE";
        $is_edit = true;
        $image_path = $this->getCategoryImagePathFull();

        return view($this->EDIT, compact('category', 'action', 'method', 'submit_text', 'is_edit', 'image_path'));
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
        $category = Category::find($id);
        $file_name_old = $category->category_image;
        $file_name = $file_name_old;

        if ($request->hasFile('category_image')) {
            $image = $request->file('category_image');
            $file_name_new = $this->getImageName().'.'.$image->getClientOriginalExtension();
            if($image->move($this->getCategoryImagePath(), $file_name_new)) {
                $file_name = $file_name_new;
                $this->deleteFile($this->getCategoryImagePath(), $file_name_old);
            }
        }

        $request = $request->all();
        $request['category_image'] = $file_name;
        $request['added_by'] = $this->getUserId();
        $request['added_ip'] = $this->getIp();

        Category::find($id)->update($request);
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
        $category = Category::find($id);
        $request['is_active'] = $this->getStatus($category->is_active);
        Category::find($id)->update($request->all());
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
        //Category::destroy($id);
        //return redirect($this->adminPanel())->withAlert($this->getDelete());
        return redirect($this->adminPanel());
    }

    public function getValidationRules($isUpdate)
    {
        if($isUpdate) {
            return [
                'category_name' => 'required|string|max:500',
                'category_image'=> 'nullable|image|max:1024' 
                ]; 
        } else {
            return [
                'category_name' => 'required|string|max:500',
                'category_image'=> 'required|image|max:1024' 
            ];
        }
    }
}
