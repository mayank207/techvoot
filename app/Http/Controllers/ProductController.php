<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        try {
            if (request()->ajax()) {
                $products = Product::select('id','name','price');
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
            return redirect()->route('login')->withError('Something went wrong, please try again');
        }
    }

    public function edit($id=null)
    {
        if(!is_null($id)){
            $product=Product::where('id',$id)->first();
            return response()->json(['success'=>true,'data'=>$product]);
        }
    }
    
    public function update(Request $request)
    {
        if(!is_null($request->productid)){
            $product=Product::where('id',$request->productid)->firstOrFail();
            $product->name=$request->editproductname;
            $product->price=$request->editproductprice;
            $product->save();
            return response()->json(['success'=>true,'message'=>"Products Updated succesfully."]);
        }
    }

    public function destroy(Request $request)
    {
        Product::where('id',$request->id)->delete();
        return response()->json(['success'=>true,'message'=>'Products removed successfully']);
    }
}
