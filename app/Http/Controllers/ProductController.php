<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // Product listing
    public function index()
    {
        try {
            if (request()->ajax()) {
                $products = Product::with('brand')->select('products.*');
                $all_products = DataTables::of($products)
                    ->editcolumn('name', function (Product $products) {
                        return $products->name??"";
                    })
                    ->editcolumn('price', function (Product $products) {
                        return $products->price??"";
                    })
                    ->editColumn('action', function (Product $products) {
                        $action = "";

                        $action .= "<a  class=\"btn btn-info btn-sm\"
                                    href=\"#\" id=\"editproduct\" data-id='".$products->id."'
                                    data-toggle=\"tooltip\" title=\"Edit\"
                                    data-placement=\"top\">
                                    edit
                                </a>";
                        $action .= "<button class=\"btn btn-danger btn-sm\"
                                href=\"#\" id=\"deleteproduct\" data-id='".$products->id."'
                                data-toggle=\"tooltip\" title=\"Edit\"
                                data-placement=\"top\">
                                Delete
                            </button>";

                        return $action;
                    })
                    ->escapeColumns([])
                    ->make(true);
                return $all_products;
            }
        } catch (\Exception $exception) {
            return redirect()->route('login')->with('toast-error','Something went wrong, please try again');
        }
    }

    //edit product
    public function edit($id=null)
    {
        if(!is_null($id)){
            $product=Product::where('id',$id)->first();
            return response()->json(['success'=>true,'data'=>$product]);
        }
    }

    //store product
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'addproductname' => 'required',
            'addproductprice' => 'required',
            'add_brand' => 'required',
        ],
        [
            'addproductname.required' => 'Please enter product name',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }
            $product=new Product;
            $product->name=$request->addproductname;
            $product->price=$request->addproductprice;
            $product->brand_id = $request->add_brand;
            $product->save();

            // if ($files = $request->file('image')) {
            //     foreach ($files as $index => $file) {
            //         $name = time() . "_" . rand(0000, 9999) . '.' . $file->getClientOriginalExtension();
            //         $images = new ProductImage();
            //         $images->product_id = $request->productid;
            //         $images->image_name = $name;
            //         $images->save();
            //     }
            // }
            return response()->json(['success'=>true,'message'=>"Products added succesfully."]);
    }

    //update product details
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'editproductname' => 'required',
            'editproductprice' => 'required',
            'edit_brand' => 'required',
        ],
        [
            'editproductname.required' => 'Please enter product name',
            'editproductprice' => 'Please enter product price',
            'edit_brand' => 'Please choose product brand',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }
        if(!is_null($request->productid)){
            $product=Product::where('id',$request->productid)->firstOrFail();
            $product->name=$request->editproductname;
            $product->price=$request->editproductprice;
            $product->brand_id = $request->edit_brand;
            $product->save();

            // if ($files = $request->file('image')) {
            //     foreach ($files as $index => $file) {
            //         $name = time() . "_" . rand(0000, 9999) . '.' . $file->getClientOriginalExtension();
            //         $images = new ProductImage();
            //         $images->product_id = $request->productid;
            //         $images->image_name = $name;
            //         $images->save();
            //     }
            // }
            return response()->json(['success'=>true,'message'=>"Products Updated succesfully."]);
        }
    }

    // Delete products
    public function destroy(Request $request)
    {
        Product::where('id',$request->id)->delete();
        return response()->json(['success'=>true,'message'=>'Products removed successfully']);
    }
}
