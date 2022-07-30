<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class BrandController extends Controller
{
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
            return redirect()->route('login')->withError('Something went wrong, please try again');
        }
    }

    public function edit($id=null)
    {
        if(!is_null($id)){
            $brand=Brand::where('id',$id)->first();
            return response()->json(['success'=>true,'data'=>$brand]);
        }
    }
    
    public function update(Request $request)
    {
        if(!is_null($request->brandid)){
            $brand=Brand::where('id',$request->brandid)->firstOrFail();
            $brand->name=$request->editbrandname;
            $brand->save();
            return response()->json(['success'=>true,'message'=>"Brands Updated succesfully."]);
        }
    }
    
    public function destroy(Request $request)
    {
        Brand::where('id',$request->id)->delete();
        return response()->json(['success'=>true,'message'=>'Brands removed successfully']);
    }

    
}
