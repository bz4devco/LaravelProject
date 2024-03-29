<?php

namespace App\Http\Controllers\Customer\SalesProcess;

use App\Models\Market\Copan;
use App\Models\Market\Order;
use Illuminate\Http\Request;
use App\Models\Market\Payment;
use App\Models\Market\CartItem;
use App\Models\Market\OrderItem;
use function PHPSTORM_META\type;
use App\Models\Market\CashPayment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Market\OnlinePayment;

use Illuminate\Support\Facades\Auth;
use App\Models\Market\OfflinePayment;
use App\Http\Services\Payment\PaymentService;
use App\Models\Market\Product;

class PaymentController extends Controller
{
    public function payment()
    {
        $orderHasCopan = Order::where('user_id', auth()->user()->id)
            ->where('order_status', 0)
            ->where('copan_id', '<>', null)
            ->first();

        $cartItems = CartItem::where('user_id', auth()->user()->id)->get();


        $order = Order::where('user_id', auth()->user()->id)
            ->where('order_status', 0)
            ->first();


        return view('customer.sales-process.payment', compact('orderHasCopan', 'cartItems', 'order'));
    }

    public function copanDiscount(Request $request)
    {
        $request->validate(
            ['code' => 'required|exists:copans,code|regex:/^[a-zA-Z0-9]+$/u']
        );



        $copan = Copan::where([['code', $request->code], ['status', 1], ['end_date', '>', now()], ['start_date', '<', now()]])->first();

        if ($copan) {
            if ($copan->user_id != null) {
                $copan = Copan::where([['code', $request->code], ['status', 1], ['end_date', '>', now()], ['start_date', '<', now()], ['user_id', Auth::user()->id]])->first();
            }
            if ($copan == null) {
                return back()->with('swal-error', 'کد تخفیف وارد شده نا معتبر است');
            }

            $order = Order::where('user_id', auth()->user()->id)
                ->where('order_status', 0)
                ->where('copan_id', null)
                ->first();
            if ($order) {

                // set copan info fields to order talbe
                $copan_object = json_encode([
                    'code' => $copan->code,
                    'amount' => $copan->amount,
                    'amount_type' => $copan->amount_type,
                    'discount_ceiling' => $copan->discount_ceiling,
                    'type' => $copan->type,
                    'start_date' => $copan->start_date,
                    'end_date' => $copan->end_date,
                    'user_id' => $copan->user_id,
                ]);

                if ($copan->amount_type == 0) {
                    $coapnDiscountAmount = $order->order_final_amount * ($copan->amount / 100);
                    if ($coapnDiscountAmount > $copan->discount_ceiling) {
                        $coapnDiscountAmount = $copan->discount_ceiling;
                    }
                } else {

                    $coapnDiscountAmount = $copan->amount;
                }


                $order->order_final_amount = $order->order_final_amount - $coapnDiscountAmount;

                $finalDiscount = $order->order_total_products_discount_amount + $coapnDiscountAmount;

                $order->update(
                    [
                        'copan_id' => $copan->id, 'order_copan_discount_amount' => $coapnDiscountAmount,
                        'order_total_products_discount_amount' => $finalDiscount,
                        'copan_object' => $copan_object
                    ]
                );

                return redirect()->back()->with('swal-success', 'کد تخفیف با موفقیت اعمال شد');
            } else {
                return back()->with('swal-error', 'درخواست نا معتبر است');
            }
        } else {
            return back()->with('swal-error', 'کد تخفیف نا معتبر است');
        }
    }


    public function paymentSubmit(Request $request, PaymentService $paymentService)
    {
        $request->validate([
            'payment_type' => 'required|in:1,2,3',
            'cash_receiver' => 'sometimes|required|min:1|max:300|regex:/^[آ-یء-ئ ]+$/u'
        ]);

        $cash_receiver = null;

        $order = Order::where('user_id', Auth::user()->id)
            ->where('order_status', 0)
            ->first();

        $cartItems = CartItem::where('user_id', Auth::user()->id)->get();

        switch ($request->payment_type) {
            case '1':
                $targetModel = OnlinePayment::class;
                $type = 0;
                break;
            case '2':
                $targetModel = OfflinePayment::class;
                $type = 1;
                break;
            case '3':
                $targetModel = CashPayment::class;
                $cash_receiver = $request->cash_receiver ?? null;
                $type = 2;
                break;
            default:
                return redirect()->with('swal-error', 'اخطا در انتخاب نوع پرداخت ');
        }


        $paymented = $targetModel::create(
            [
                'amount' => $order->order_final_amount,
                'user_id' => auth()->user()->id,
                'pay_date' => now(),
                'cash_receiver' => $cash_receiver,
                'gateway' => 'زرین پال',
                'status' => 1
            ]
        );


        $payment = Payment::create(
            [
                'amount' => $order->order_final_amount,
                'user_id' => auth()->user()->id,
                'pay_date' => now(),
                'type' => $type,
                'paymentable_id' => $paymented->id,
                'paymentable_type' => $targetModel,
                'status' => 1
            ]
        );

        $payment_object = json_encode([
            'amount' => $payment->amount,
            'user_id' => $payment->user_id,
            'status' => $payment->status,
            'type' => $payment->type,
            'paymentable_type' => $payment->paymentable_type,
        ]);


        if ($request->payment_type == 1) {
            $paymentService->zarinpal($order->order_final_amount, $order, $paymented);
        }

        DB::transaction(function () use ($order, $payment, $payment_object, $cartItems) {

            $order->update(
                [
                    'order_status' => 2,
                    'payment_id' => $payment->id,
                    'payment_object' => $payment_object
                ]
            );
            foreach ($cartItems as $cartItem) {
                // create order items
                OrderItem::create([
                    'order_id'                          => $order->id,
                    'product_id'                        => $cartItem->product_id,
                    'products'                          => $cartItem->product,
                    'amazing_sale_id'                   => $cartItem->product->activeAmazingSales()->id ?? null,
                    'amazing_sale_object'               => $cartItem->product->activeAmazingSales() ?? null,
                    'amazing_sale_discount_amount'      => empty($cartItem->product->activeAmazingSales()) ? 0 :
                        $cartItem->cartItemProductPrice() * ($cartItem->product->activeAmazingSales()->percentage / 100),

                    'number'                            => $cartItem->number,
                    'final_product_price'               => empty($cartItem->product->activeAmazingSales()) ? $cartItem->cartItemProductPrice() :
                        $cartItem->cartItemProductPrice() - ($cartItem->cartItemProductPrice() * ($cartItem->product->activeAmazingSales()->percentage / 100)),

                    'final_total_product_price'         => empty($cartItem->product->activeAmazingSales()) ? $cartItem->cartItemProductPrice() * ($cartItem->number) :
                        $cartItem->cartItemProductPrice() - ($cartItem->cartItemProductPrice() * ($cartItem->product->activeAmazingSales()->percentage / 100) * ($cartItem->number)),

                    'color_id'                          => $cartItem->color_id,
                    'guarantee_id'                      => $cartItem->guarantee_id,
                ]);


                $product = Product::where('id', $cartItem->product_id)->first();
                if($product){
                    $product->marketable_number = $product->marketable_number - $cartItem->number;
                    $product->frozen_number = $product->frozen_number - $cartItem->number;
                    $product->sold_number = $product->sold_number + $cartItem->number;
                    $product->save();
                }

                $cartItem->delete();
            }
        });
        return to_route('customer.home')->with('swal-success', 'سفارش شما با موفقیت ثبت شد');
    }



    public function paymentCallback(Order $order, OnlinePayment $onlinePayment, PaymentService $paymentService)
    {
        $amount = $onlinePayment->amount;
        $result = $paymentService->zarinpalVerify($amount, $onlinePayment);
        $cartItems = CartItem::where('user_id', Auth::user()->id)->get();

        DB::transaction(function () use ($onlinePayment, $order, $cartItems, $result) {


            $payment_object = json_encode([
                'amount' => $onlinePayment->amount,
                'user_id' => $onlinePayment->user_id,
                'status' => $onlinePayment->status,
                'type' => $onlinePayment->type,
                'paymentable_type' => $onlinePayment->paymentable_type,
            ]);

            foreach ($cartItems as $cartItem) {
                // create order items
                OrderItem::create([
                    'order_id'                          => $order->id,
                    'product_id'                        => $cartItem->product_id,
                    'products'                          => $cartItem->product,
                    'amazing_sale_id'                   => $cartItem->product->activeAmazingSales()->id ?? null,
                    'amazing_sale_object'               => $cartItem->product->activeAmazingSales() ?? null,
                    'amazing_sale_discount_amount'      => empty($cartItem->product->activeAmazingSales()) ? 0 :
                        $cartItem->cartItemProductPrice() * ($cartItem->product->activeAmazingSales()->percentage / 100),

                    'number'                            => $cartItem->number,
                    'final_product_price'               => empty($cartItem->product->activeAmazingSales()) ? $cartItem->cartItemProductPrice() :
                        $cartItem->cartItemProductPrice() - ($cartItem->cartItemProductPrice() * ($cartItem->product->activeAmazingSales()->percentage / 100)),

                    'final_total_product_price'         => empty($cartItem->product->activeAmazingSales()) ? $cartItem->cartItemProductPrice() * ($cartItem->number) :
                        $cartItem->cartItemProductPrice() - ($cartItem->cartItemProductPrice() * ($cartItem->product->activeAmazingSales()->percentage / 100) * ($cartItem->number)),

                    'color_id'                          => $cartItem->color_id,
                    'guarantee_id'                      => $cartItem->guarantee_id,
                ]);

                if ($result['success']) {
                    $product = Product::where('id', $cartItem->product_id)->first();
                    if($product){
                        $product->marketable_number = $product->marketable_number - $cartItem->number;
                        $product->frozen_number = $product->frozen_number - $cartItem->number;
                        $product->sold_number = $product->sold_number + $cartItem->number;
                        $product->save();
                    }
                }
                // delete all cart items for cutomer
                $cartItem->delete();
            }
            if ($result['success']) {

                $order->update(
                    [
                        'order_status' => 2,
                        'payment_id' => $onlinePayment->payments[0]->id,
                        'payment_object' => $payment_object
                    ]
                );

            } else {
                $order->update(
                    [
                        'order_status' => 1,
                        'payment_id' => $onlinePayment->payments[0]->id,
                        'payment_object' => $payment_object
                    ]
                );
            }
        });

        if ($result['success']) {
            return to_route('customer.home')->with('swal-succrss', 'پرداخت شما با موفقیت انجام شد');
        } else {
            return to_route('customer.sales-process.cart')->with('swal-error', 'پرداخت شما با شکست مواجه شد');
        }
    }
}
