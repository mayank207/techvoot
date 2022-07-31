<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
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

    /*delete the media of product*/
    public function productMediaDelete(Request $request)
    {
        $business_images = ProductImage::where('id', $request->id)->delete();
        if ($business_images) {

            return response()->json(['status' => "success", 'message' => 'Product media delete successfully.']);
        } else {
            return response()->json(['status' => "success", 'message' => 'Something went wrong.']);
        }
    }
    /*For fetch the media of business*/
    public function productMedia(id $id)
    {
        dd($id);
        $product_media = ProductImage::where('product_id', $id)->orderBy('id', 'desc')->get();
        return view('customer.profile.myprofile', compact('product_media'));
    }

    public function uploadProductMedia(Request $request)
    {
        dd($request->all());
        $validator = Validator::make($request->all(), [
            'file' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'status' => 401, 'message' => $validator->errors()->first()]);
        } else {
            $ismime = $request->file->getClientMimeType();
            if (strstr($ismime, "image/")) {
                $validator = Validator::make($request->all(), [
                    'file' => 'mimetypes:image/jpg,image/jpeg,image/png|max:20480'
                ], [
                    'file.max' => 'File is larger than 20MB'
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'file' => 'mimetypes:video/mp4,video/x-msvideo,video/quicktime|max:204800'
                ], [
                    'file.max' => 'File is larger than 200MB'
                ]);
            }

            if ($validator->fails()) {
                return response()->json(['success' => false, 'status' => 401, 'message' => $validator->errors()->first()]);
            }
        }
        try {
            $user_id = getDecrypted($user_id);
            $original_name = $request->file->getClientOriginalName();
            $mime = $request->file->getClientMimeType();
            $filesize = formatBytes($request->file->getSize(), 2);
            $extension = $request->file->extension();
            $file_name = time() . rand() . '.' . $extension;
            $image_extension = ['jpg', 'jpeg', 'png'];
            $thumb_name = 'thumb_' . time() . rand() . '.png';
            $destination_path = public_path('uploads/business_images');
            $thumbnail_source_path = '';
            $media_type = '';

            if (!in_array($extension, $image_extension)) {
                $media_type = 'video';
                // Video thumbnail
                $thumbnail_status = Thumbnail::getThumbnail($request->file->getRealPath(), $destination_path, $thumb_name, env('TIME_TO_TAKE_SCREENSHOT'));
                if ($thumbnail_status) {
                    $thumbnail_source_path = $destination_path . '/' . $thumb_name;
                } else {

                    return response()->json(['success' => false, 'status' => 401, 'message' => 'Something went wrong. Please try again.']);
                }
            } else {
                $media_type = 'image';
                // Image thumbnail
                $thumbnail_source_path = $destination_path . '/' . $thumb_name;
                // Local Thumbnail Url
                Image::make($request->file->getRealPath())->fit(env('THUMBNAIL_IMAGE_WIDTH'), env('THUMBNAIL_IMAGE_HEIGHT'), NULL, 'top')->save($thumbnail_source_path, 85);
                //End Generate thumbnail
            }

            $thumbnail_image_key = Storage::disk('s3')->putFileAs('business/media', $thumbnail_source_path, $thumb_name, ['ACL' => 'public-read']);
            $thumbnail_image_url = Storage::disk('s3')->url($thumbnail_image_key);
            unlink($thumbnail_source_path);

            $business_media_key = Storage::disk('s3')->putFileAs('business/media', $request->file->getRealPath(), $file_name, ['ACL' => 'public-read']);
            $business_media_url = Storage::disk('s3')->url($business_media_key);

            $add_media = new BusinessMedia;
            $add_media->user_id = $user_id;
            $add_media->type = 'photos';
            $add_media->media_type = $media_type;
            $add_media->media_url = $business_media_url;
            $add_media->media_s3_key = $business_media_key;
            $add_media->media_size = $filesize;
            $add_media->media_mime = $mime;
            $add_media->original_name = $original_name;
            $add_media->thumbnail = $thumbnail_image_url;
            $add_media->thumbnail_s3_key = $thumbnail_image_key;
            $add_media->save();

            $business_media = BusinessMedia::where('user_id', $user_id)->orderBy('id', 'desc')->get();
            $view = view('customer.components.business_media', compact('business_media'))->render();
            return response()->json(['success' => true, 'status' => 200, 'html' => $view, 'message' => 'Media uploaded successfully.', '']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'status' => 401, 'message' => $e->getMessage()]);
        }
    }
}
