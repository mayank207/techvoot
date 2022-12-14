<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    // Brands listing
    public function index()
    {
        try {
            if (request()->ajax()) {
                $products = Brand::select('id','name');
                $all_brands = DataTables::of($products)
                    ->editcolumn('name', function (Brand $brand) {
                        return $brand->name??"";
                    })
                    ->editColumn('action', function (Brand $brand) {
                        $action = "";

                        $action .= "<a  class=\"btn btn-info btn-sm\"
                                    href=\"#\" id=\"editbrand\" data-id='".$brand->id."'
                                    data-toggle=\"tooltip\" title=\"Edit\"
                                    data-placement=\"top\">
                                    <i class=\"material-icons\">edit</i>
                                </a>";

                        $action .= "<button class=\"btn btn-danger btn-sm\"
                                href=\"#\" id=\"deletebrand\" data-id='".$brand->id."'
                                data-toggle=\"tooltip\" title=\"Edit\"
                                data-placement=\"top\">
                                Delete
                            </button>";
                        return $action;
                    })
                    ->escapeColumns([])
                    ->make(true);
                return $all_brands;
            }
        } catch (\Exception $exception) {
            return redirect()->route('login')->with('toast-error','Something went wrong, please try again');
        }
    }

    // edit brand
    public function edit($id=null)
    {
        if(!is_null($id)){
            $brand=Brand::where('id',$id)->first();
            return response()->json(['success'=>true,'data'=>$brand]);
        }
    }

    // Store new brand
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'addbrandname' => 'required',
        ],
        [
            'addbrandname.required' => 'Please enter product name',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }
            $brand=new Brand;
            $brand->name=$request->addbrandname;
            $brand->save();
            return response()->json(['success'=>true,'message'=>"Brands added succesfully."]);
    }

    // update exsits brand
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'editbrandname' => 'required',
        ],
        [
            'editbrandname.required' => 'Please enter product name',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }
        if(!is_null($request->brandid)){
            $brand=Brand::where('id',$request->brandid)->firstOrFail();
            $brand->name=$request->editbrandname;
            $brand->save();
            return response()->json(['success'=>true,'message'=>"Brands Updated succesfully."]);
        }
    }

    // delete brand
    public function destroy(Request $request)
    {
        Brand::where('id',$request->id)->delete();
        return response()->json(['success'=>true,'message'=>'Brands removed successfully']);
    }


}
