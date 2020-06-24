<?php

namespace GroceryApp\Http\Controllers\Product;

use GroceryApp\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use GroceryApp\Models\Units;
use GroceryApp\Models\Brand;

use GroceryApp\Models\Category\Category;
use GroceryApp\Models\Category\SubCategory;
use GroceryApp\Models\Category\SubSubCategory;

use GroceryApp\Models\Product\Product;
use GroceryApp\Models\Product\ProductQuantity;
use GroceryApp\Models\Product\ProductImage;

class ProductController extends Controller
{
    protected $redirectTo = 'product';

    protected $VIEW  = 'product.view_product';
    protected $ADD   = 'product.add_product';
    protected $EDIT  = 'product.edit_product';
    protected $SHOW  = 'product.show_product';
    protected $SHOW_QUANTITY  = 'product.show_product_quantity';
    protected $ADD_IMAGES = 'product.add_images';

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
        $products = Product::with('category', 'subCategory', 'subSubCategory', 'productQuantity', 'productQuantity.unit', 'productImages')->orderBy('product_id', 'DESC')->get(); 
        $image_path = $this->getProductImagePathFull();
        return view($this->VIEW, compact('products', 'image_path'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = new Product;
        $action = route('product.insertProduct');
        $method = 'POST';
        $submit_text = "SUBMIT";

        $categories = Category::has('subCategory', '>' , 0)->with([
            'subCategory' => function($q){
                $q->where('is_active', 1);
            },
            'subCategory.subSubCategory' => function($q){
                $q->where('is_active', 1);
            }
        ])->where('is_active', 1)->get(); 
        
        $sub_categories = SubCategory::all()->where('is_active', 1);
        $sub_sub_categories = SubSubCategory::all()->where('is_active', 1);

        $brands = Brand::all()->where('is_active', 1);
        $units = Units::all()->where('is_active', 1);

        return view($this->ADD, compact('brands', 'categories', 'units', 'product', 'action', 'method', 'submit_text', 'sub_categories', 'sub_sub_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function insertProduct(Request $request)
    {
        if($request->ajax()) {
            $validator = Validator::make($request->all(), $this->getValidationRules(false));
            if ($validator->fails()) {
                return $this->getJson(['error'  => $validator->errors()->all()]);
            }

            $destinationPath = $this->getImagePath(); //public_path('/upload');

            if ($request->hasFile('product_image')) {
                try {
                    DB::beginTransaction();
                    $image = $request->file('product_image');
                    $file_name = $this->getImageName().'.'.$image->getClientOriginalExtension();
                    $image->move($destinationPath, $file_name);
                    
                    $product = Product::create([
                        'brand_id' => $request->brand_id,  
                        'category_id' => $request->category_id,  
                        'sub_category_id' => $request->sub_category_id,  
                        'sub_sub_category_id' => $request->sub_sub_category_id,  
                        'product_name' => $request->product_name,  
                        'product_description' => $request->product_description,  
                        'items_in_stock' => $request->items_in_stock,  
                        'product_image' => $file_name,
                        'in_stock' => ($request->in_stock == "on") ? 1 : 0,
                        'is_daily_essential' => ($request->is_daily_essential == "on") ? 1 : 0,
                        'is_top_selling' => ($request->is_top_selling == "on") ? 1 : 0,
                        'meta_tag' => $request->meta_tag,   
                        'meta_desc' => $request->meta_desc,  
                        'added_by' => $this->getUserId(),
                        'added_ip' => $this->getIp()
                    ]);

                    $items_multiplier_array = $request->items_multiplier;
                    $product_quantity_array = $request->product_quantity;
                    $unit_id_array = $request->unit_id;
                    $product_price_array = $request->product_price;
                    $product_offer_percent_array = $request->product_offer_percent;

                    foreach ($items_multiplier_array as $index => $items_multiplier) {
                       $quantity_data[] = [
                        'product_id' => $product->product_id,
                        'items_multiplier' => $items_multiplier_array[$index],
                        'product_quantity'  => $product_quantity_array[$index],
                        'unit_id'  => $unit_id_array[$index],
                        'product_price'  => $product_price_array[$index],
                        'product_offer_percent'  => $product_offer_percent_array[$index],
                        'added_by' => $this->getUserId(),
                        'added_ip' => $this->getIp()
                       ];
                    }
                    ProductQuantity::insert($quantity_data);

                    if ($request->hasFile('product_other_images')) {
                        foreach ($request->file('product_other_images') as $key => $addnlImage) {
                            $file_name = $this->getImageName().'.'.$addnlImage->getClientOriginalExtension();
                            $addnlImage->move($destinationPath, $file_name);
                            $image_data[] = [
                                'product_id' => $product->product_id,
                                'product_image' => $file_name,
                                'added_by' => $this->getUserId(),
                                'added_ip' => $this->getIp()
                            ];
                        }
                        ProductImage::insert($image_data);
                    }
                    DB::commit();
                    /*return response()->json([
                                   'success'  => 'Item saved successfully'
                                ]);*/
                    return $this->getJson(['success'  => 'Item saved successfully']);
                }  catch (\Exception $exception) {
                    DB::rollBack();
                    $error[] = 'Error : Upload Failed '.$exception->getMessage();
                    return $this->getJson(['error'  => $error]);
                }                
            } else {
                $error[] = 'Unknown error occured.';
                return $this->getJson(['error'  => $error]);
            }
        } else {
            $error[] = 'Unknown error occured !!';
            return $this->getJson(['error'  => $error]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProduct(Request $request, $id)
    {
        if($request->ajax()) {
            $validator = Validator::make($request->all(), $this->getValidationRules(true));
            if ($validator->fails()) {
                return $this->getJson(['error'  => $validator->errors()->all()]);
            }
            $product = Product::find($id);

            $file_name_old = $product->product_image;
            $file_name = $file_name_old;

            $destinationPath = $this->getImagePath();

            if ($request->hasFile('product_image')) {
                $image = $request->file('product_image');
                $file_name_new = $this->getImageName().'.'.$image->getClientOriginalExtension();
                if($image->move($destinationPath, $file_name_new)) {
                   $file_name = $file_name_new;
                   $this->deleteFile($destinationPath, $file_name_old);
                }
            }

            $product_data = [
                        'brand_id' => $request->brand_id,  
                        'category_id' => $request->category_id,  
                        'sub_category_id' => $request->sub_category_id,  
                        'sub_sub_category_id' => $request->sub_sub_category_id,  
                        'product_name' => $request->product_name,  
                        'product_description' => $request->product_description,  
                        'items_in_stock' => $request->items_in_stock,  
                        'product_image' => $file_name,
                        'in_stock' => ($request->in_stock == "on") ? 1 : 0,
                        'is_daily_essential' => ($request->is_daily_essential == "on") ? 1 : 0,
                        'is_top_selling' => ($request->is_top_selling == "on") ? 1 : 0,
                        'meta_tag' => $request->meta_tag,   
                        'meta_desc' => $request->meta_desc,  
                        'added_by' => $this->getUserId(),
                        'added_ip' => $this->getIp()
                    ];

            Product::find($id)->update($product_data);

            $quantity_id_array = $request->quantity_id;
            $items_multiplier_array = $request->items_multiplier;
            $product_quantity_array = $request->product_quantity;
            $unit_id_array = $request->unit_id;
            $product_price_array = $request->product_price;
            $product_offer_percent_array = $request->product_offer_percent;
            $quantity_in_stock_array = $request->quantity_in_stock;

            foreach ($quantity_id_array as $index => $quantity_id) {
                $is_in_stock = (isset($quantity_in_stock_array[$index]) && $quantity_in_stock_array[$index] == "on") ? 1 : 0;
                
                $quantity_data = [
                    'product_id' => $id,
                    'items_multiplier' => $items_multiplier_array[$index],
                    'product_quantity'  => $product_quantity_array[$index],
                    'unit_id'  => $unit_id_array[$index],
                    'product_price'  => $product_price_array[$index],
                    'product_offer_percent'  => $product_offer_percent_array[$index],
                    'in_stock' => $is_in_stock,
                    'added_by' => $this->getUserId(),
                    'added_ip' => $this->getIp()
                ];
                ProductQuantity::find($quantity_id_array[$index])->update($quantity_data);
            }

            return $this->getJson(['success'  => 'Item saved successfully']);
        } else {
            $error[] = 'Unknown error occured !!';
            return $this->getJson(['error'  => $error]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showProductQuantity($id) 
    {
        $product = Product::with('productQuantity', 'productQuantity.unit')->where('product_id', $id)->get()->first();  
        $action  = route('product.insertProductQuantity',$product->product_id);
        $is_show_quantity = true;
        $units = Units::all()->where('is_active', 1);
        return view($this->SHOW_QUANTITY, compact('product', 'units', 'is_show_quantity' , 'action'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function insertProductQuantity(Request $request, $id) 
    {
        if($request->ajax()) {
            $rules = [
                     'items_multiplier.*'  => 'required|numeric',
                     'product_quantity.*'  => 'required|numeric',
                     'unit_id.*'  => 'required|numeric',
                     'product_price.*'  => 'required|numeric',
                     'product_offer_percent.*'  => 'required|numeric'
                    ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->getJson(['error'  => $validator->errors()->all()]);
            }

            $items_multiplier_array = $request->items_multiplier;
            $product_quantity_array = $request->product_quantity;
            $unit_id_array = $request->unit_id;
            $product_price_array = $request->product_price;
            $product_offer_percent_array = $request->product_offer_percent;

            foreach ($items_multiplier_array as $index => $items_multiplier) {
                 $quantity_data[] = [
                    'product_id' => $id,
                    'items_multiplier' => $items_multiplier_array[$index],
                    'product_quantity'  => $product_quantity_array[$index],
                    'unit_id'  => $unit_id_array[$index],
                    'product_price'  => $product_price_array[$index],
                    'product_offer_percent'  => $product_offer_percent_array[$index],
                    'added_by' => $this->getUserId(),
                    'added_ip' => $this->getIp()
                ];
            } 
            ProductQuantity::insert($quantity_data);  
            return $this->getJson(['success'  => 'Item saved successfully']);
        } else {
            $error[] = 'Unknown error occured !!';
            return $this->getJson(['error'  => $error]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('brand', 'category', 'subCategory', 'subSubCategory', 'productQuantity', 'productQuantity.unit', 'productImages')->where('product_id', $id)->get()->first();
        //echo json_encode($product, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        //exit;  
        $image_path = $this->getProductImagePathFull();
        return view($this->SHOW, compact('product', 'image_path'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $action  = route('product.updateProduct',$product->product_id);
        $method  = 'POST';
        $submit_text = "UPDATE";
        $is_edit = true;
        
        $categories = Category::has('subCategory', '>' , 0)->with('subCategory', 'subCategory.subSubCategory')->get(); 

        $brands = Brand::all();
        $units = Units::all();

        $productQuantities = $product->productQuantity()->get();

        return view($this->EDIT, compact('brands', 'categories', 'units', 'product', 'productQuantities', 'action', 'method', 'submit_text', 'is_edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateProductStatus($id)
    {
        $request = new Request;
        $product = Product::find($id);
        $request['is_active'] = $this->getStatus($product->is_active);
        Product::find($id)->update($request->all());
        return redirect($this->adminPanel())->withAlert($this->getUpdate());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateProductInStockStatus($id)
    {
        $request = new Request;
        $product = Product::find($id);
        $request['in_stock'] = $this->getInStockStatus($product->in_stock);
        Product::find($id)->update($request->all());
        return redirect($this->adminPanel())->withAlert($this->getUpdate());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateProductQuantityStatus($id)
    {
        $request = new Request;
        $product_quantity = ProductQuantity::find($id); 
        $request['is_active'] = $this->getInStockStatus($product_quantity->is_active);
        ProductQuantity::find($id)->update($request->all());
        return redirect()->back()->withAlert($this->getUpdate());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateProductQuantityInStockStatus($id)
    {
        $request = new Request;
        $product_quantity = ProductQuantity::find($id); 
        $request['in_stock'] = $this->getInStockStatus($product_quantity->in_stock);
        ProductQuantity::find($id)->update($request->all());
        return redirect()->back()->withAlert($this->getUpdate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addProductImages($id) 
    { 
        $action  = route('product.insertProductImages', $id);
        $method = 'POST';
        return view($this->ADD_IMAGES, compact('action', 'method'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function insertProductImages(Request $request, $id) 
    {
        $rules = [
             'product_other_images' => 'required|array',
             'product_other_images.*' => 'required|image|max:1024'];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator, 'formError');
        }
        $destinationPath = $this->getImagePath();
        try {
            if ($request->hasFile('product_other_images')) {
                foreach ($request->file('product_other_images') as $key => $addnlImage) {
                    $file_name = $this->getImageName().'.'.$addnlImage->getClientOriginalExtension();
                    $addnlImage->move($destinationPath, $file_name);
                    $image_data[] = [
                        'product_id' => $id,
                        'product_image' => $file_name,
                        'added_by' => $this->getUserId(),
                        'added_ip' => $this->getIp()
                    ];
                }
                ProductImage::insert($image_data);
                return redirect($this->adminPanel())->withAlert($this->getUpdate());
            }
            $error['product_other_images'] = 'Upload Failed';
            return redirect()->back()->withInput($request->input())->withErrors($error, 'formError');
        }  catch (\Exception $exception) {
            $error['product_other_images'] = 'Upload Failed '.$exception->getMessage();
            return redirect()->back()->withInput($request->input())->withErrors($error, 'formError');
        }          
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyProductOtherImage($id)
    {
        $product_image = ProductImage::find($id); 
        $file_name = $product_image->product_image;
        $this->deleteFile($this->getImagePath(), $file_name);
        ProductImage::destroy($id);
        return redirect()->back()->withAlert($this->getDelete());
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect($this->adminPanel());
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
    }

    public function getValidationRules($isUpdate)
    {
        if($isUpdate) {
            // Rules to Update
            return [
             'quantity_id.*' => 'required|numeric',
             'brand_id' => 'required|numeric',
             'category_id' => 'required|numeric',
             'sub_category_id' => 'required|numeric',
             'sub_sub_category_id' => 'required|numeric',
             'product_name' => 'required|string',
             'product_image'=> 'nullable|image|max:1024',
             'product_description' => 'required|string',
             'items_multiplier.*'  => 'required|numeric',
             'product_quantity.*'  => 'required|numeric',
             'unit_id.*'  => 'required|numeric',
             'product_price.*'  => 'required|numeric',
             'product_offer_percent.*'  => 'required|numeric',
             'product_other_images.*'=> 'nullable|image|max:1024',
            ];
        }
        else {
            // Rules to Insert
            return [
             'brand_id' => 'required|numeric',
             'category_id' => 'required|numeric',
             'sub_category_id' => 'required|numeric',
             'sub_sub_category_id' => 'required|numeric',
             'product_name' => 'required|string',
             'product_image'=> 'required|image|max:1024',
             'product_description' => 'required|string',
             'items_in_stock' => 'required|numeric',
             'items_multiplier.*'  => 'required|numeric',
             'product_quantity.*'  => 'required|numeric',
             'unit_id.*'  => 'required|numeric',
             'product_price.*'  => 'required|numeric',
             'product_offer_percent.*'  => 'required|numeric',
             'product_other_images.*'=> 'nullable|image|max:1024',
            ];
        }
    }

    protected function getImagePath() {
        return  $this->getProductImagePath();
    }
}
