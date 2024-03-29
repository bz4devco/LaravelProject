<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\DeliveryRequest;
use App\Models\Market\Delivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $delivery_methods = Delivery::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.market.delivery.index', compact('delivery_methods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.market.delivery.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeliveryRequest $request, Delivery $delivery)
    {
        $inputs = $request->all();
        $delivery->create($inputs);
        return to_route('admin.market.delivery.index')
        ->with('alert-section-success', 'روش ارسال جدید شما با موفقیت ثبت شد');
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
    public function edit(Delivery $delivery)
    {
        return view('admin.market.delivery.edit', compact('delivery'));    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DeliveryRequest $request, Delivery $delivery)
    {
        $inputs = $request->all();
        $delivery->update($inputs);
        return to_route('admin.market.delivery.index')
        ->with('alert-section-success', 'ویرایش روش ارسال شماره   '.$delivery->id .' با موفقیت انجام شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delivery $delivery)
    {
        $result = $delivery->delete();
        return to_route('admin.market.deleivery.index')
        ->with('alert-section-success', 'روش ارسال شماره '.$delivery->id.' با موفقیت حذف شد');
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(Delivery $delivery)
    {
        $delivery->status = $delivery->status == 0 ? 1 : 0;
        $result = $delivery->save();

        if($result){
            if($delivery->status == 0){
                return response()->json(['status' => true, 'checked' => false, 'id' => $delivery->id]);
            }else{
                return response()->json(['status' => true, 'checked' => true, 'id' => $delivery->id]);
            }
        }else{
            return response()->json(['status' => false]);
        }
    }
}
