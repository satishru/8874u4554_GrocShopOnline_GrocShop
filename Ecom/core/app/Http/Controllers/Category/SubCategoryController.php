<?php

namespace GroceryApp\Http\Controllers\Category;

use GroceryApp\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use GroceryApp\Models\Category\Category;
use GroceryApp\Models\Category\SubCategory;

class SubCategoryController extends Controller
{
    protected $redirectTo = 'category_sub';

    protected $VIEW  = 'categories.category_sub.view_sub_category';
    protected $ADD   = 'categories.category_sub.add_sub_category';
    protected $EDIT  = 'categories.category_sub.edit_sub_category';

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
        $sub_categories = SubCategory::with('category')->get();
        $image_path = $this->getCategoryImagePathFull();
        return view($this->VIEW, compact('sub_categories', 'image_path'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all()->where('is_active', 1);
        $sub_category = new SubCategory;
        $action = route('category_sub.store');
        $method = "POST";
        $submit_text = "SUBMIT";

        return view($this->ADD, compact('categories', 'sub_category', 'action', 'method', 'submit_text'));
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
        $image = $request->file('sub_category_image');
        $file_name = $this->getImageName().'.'.$image->getClientOriginalExtension();
        if($image->move($this->getCategoryImagePath(), $file_name)) {
            SubCategory::create([
                'category_id' => $request->category_id,
                'sub_category_name' => $request->sub_category_name,
                'sub_category_description' => $request->sub_category_description,
                'sub_category_image' => $file_name,
                'meta_tag' => $request->meta_tag,
                'meta_desc' => $request->meta_desc,
                'added_by' => $this->getUserId(),
                'added_ip' => $request->ip()
            ]);
            return redirect($this->adminPanel())->withAlert($this->getSuccess());
        } else {
            return redirect()->back()->withInput()->withErrors(['sub_category_image' => ['Image Upload failed']]);
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
        $categories = Category::all()->where('is_active', 1);
        $sub_category = SubCategory::find($id);
        $action = route('category_sub.update', $sub_category->sub_category_id);
        $method = "PUT";
        $submit_text = "UPDATE";
        $is_edit = true;
        $image_path = $this->getCategoryImagePathFull();

        return view($this->EDIT, compact('categories', 'sub_category', 'action', 'method', 'submit_text', 'is_edit', 'image_path'));
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
        $sub_category = SubCategory::find($id);
        $file_name_old = $sub_category->sub_category_image;
        $file_name = $file_name_old;

        if ($request->hasFile('sub_category_image')) {
            $image = $request->file('sub_category_image');
            $file_name_new = $this->getImageName().'.'.$image->getClientOriginalExtension();
            if($image->move($this->getCategoryImagePath(), $file_name_new)) {
                $file_name = $file_name_new;
                $this->deleteFile($this->getCategoryImagePath(), $file_name_old);
            }
        }

        $ip = $request->ip();
        $request = $request->all();
        $request['sub_category_image'] = $file_name;
        $request['added_by'] = $this->getUserId();
        $request['added_ip'] = $ip;

        SubCategory::find($id)->update($request);
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
        $category = SubCategory::find($id);
        $request['is_active'] = $this->getStatus($category->is_active);
        SubCategory::find($id)->update($request->all());
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
        //SubCategory::destroy($id);
        //return redirect($this->adminPanel())->withAlert($this->getDelete());
        return redirect($this->adminPanel());
    }

    public function getValidationRules($isUpdate)
    {
        if($isUpdate) {
            return [
                'category_id' => 'required|numeric',
                'sub_category_name' => 'required|string|max:500',
                'sub_category_image'=> 'nullable|image|max:1024'
                ];
        } else {
            return [
                'category_id' => 'required|numeric',
                'sub_category_name' => 'required|string|max:500',
                'sub_category_image'=> 'required|image|max:1024'
            ];
        }
    }
}
