<?php

namespace App\Http\Controllers\Admin\Market;

use App\Models\Market\Brand;
use Illuminate\Http\Request;
use App\Models\Market\Product;
use App\Models\Market\ProductMeta;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Market\ProductCategory;
use App\Http\Services\Image\ImageService;
use App\Http\Requests\Admin\Market\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!is_null($request)){
            $sreach = checkRequest($request->search) ?? null;
            if($sreach){
                $products = Product::where('name', 'LIKE', "%" . $sreach . "%")->paginate(15);
            }else{
                $products = Product::orderBy('created_at', 'desc')->paginate(15);
            }
        }else{
            $products = Product::orderBy('created_at', 'desc')->paginate(15);
        }
        return view('admin.market.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productCategoreis = ProductCategory::whereNotNull('parent_id')->get(['id', 'name']);
        $brands = Brand::all(['id', 'persian_name']);
        return view('admin.market.product.create', compact('productCategoreis', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request, Product $product, ImageService $imageservice)
    {

        $inputs = $request->all();


        // date fixed
        $realTimestampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);


        // image Upload
        if ($request->hasFile('image')) {
            $imageservice->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'product');
            $result = $imageservice->createIndexAndSave($request->file('image'), true);
            if ($result === false) {
                return to_route('admin.market.product.create')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        }


        // use transaction for multi oprations and back after warning oprations
        DB::transaction(function () use ($inputs, $request, $product) {
            // store data in database
            $product = $product->create($inputs);
            if ($request->meta_key != null) {
                $metas = array_combine($request->meta_key, $request->meta_value);

                // create metas in database
                foreach ($metas as $key => $value) {
                    $meta = ProductMeta::create([
                        'meta_key'      => $key,
                        'meta_value'    => $value,
                        'product_id'    => $product->id,
                    ]);
                }
            }
        });
        return to_route('admin.market.product.index')
            ->with('alert-section-success', 'کالای جدید شما با موفقیت ثبت شد');
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadImagesCkeditor(Request $request, ImageService $imageService)
    {
        $request->validate([
            'upload' => 'sometimes|required|max:10240|image|mimes:png,jpg,jpeg,gif,ico,svg,webp'
        ]);
        // image Upload
        if ($request->hasFile('upload')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'product-introduction');
            $url = $imageService->save($request->file('upload'));
            $url = str_replace('\\', '/', $url);
            $url = asset($url);

            return "<script>window.parent.CKEDITOR.tools.callFunction(1, '{$url}' , '')</script>";
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $productCategoreis = ProductCategory::whereNotNull('parent_id')->get(['id', 'name']);
        $brands = Brand::all(['id', 'persian_name']);
        $timestampStart = strtotime($product['published_at']);
        $product['published_at'] = $timestampStart . '000';

        return view('admin.market.product.edit', compact('product', 'productCategoreis', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product, ImageService $imageservice)
    {

        $inputs = $request->all();


        // date fixed
        $realTimestampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);


        // image Upload
        if ($request->hasFile('image')) {
            if (!empty($product)) {
                $imageservice->deleteDirectoryAndFiles($product->image['directory']);
            }
            $imageservice->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'product');
            $result = $imageservice->createIndexAndSave($request->file('image'), true);
            if ($result === false) {
                return to_route('admin.market.product.edit', $product->id)->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        } else {
            if (isset($inputs['currentImage']) && !empty($product->image)) {
                $image = $product->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image'] = $image;
            }
        }


        // use transaction for multi oprations and back after warning oprations
        DB::transaction(function () use ($inputs, $request, $product) {
            // store data in database
            $product->update($inputs);

            if ($request->meta_key != null) {
                $metas = array_combine($request->meta_key, $request->meta_value);
                // update metas in database
                $result = ProductMeta::where('product_id', $product->id)->delete();
                if ($result) {
                    // create metas in database
                    foreach ($metas as $key => $value) {
                        if (!empty($key) && !empty($value)) {
                            $meta = ProductMeta::create([
                                'meta_key'      => $key,
                                'meta_value'    => $value,
                                'product_id'    => $product->id,
                            ]);
                        }
                    }
                }
            }
        });
        return to_route('admin.market.product.index')
            ->with('alert-section-success', ' ویرایش کالا با نام ' . $product->name . ' با موفقیت انجام شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $result = $product->delete();
        return to_route('admin.market.product.index')
            ->with('alert-section-success', ' کالا با نام ' . $product->name . ' با موفقیت حذف شد');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(Product $product)
    {
        $product->status = $product->status == 0 ? 1 : 0;
        $result = $product->save();

        if ($result) {
            if ($product->status == 0) {
                return response()->json(['status' => true, 'checked' => false, 'id' => $product->name]);
            } else {
                return response()->json(['status' => true, 'checked' => true, 'id' => $product->name]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function marketable(Product $product)
    {
        $product->marketable = $product->marketable == 0 ? 1 : 0;
        $result = $product->save();

        if ($result) {
            if ($product->marketable == 0) {
                return response()->json(['marketable' => true, 'checked' => false, 'id' => $product->name]);
            } else {
                return response()->json(['marketable' => true, 'checked' => true, 'id' => $product->name]);
            }
        } else {
            return response()->json(['marketable' => false]);
        }
    }
}
