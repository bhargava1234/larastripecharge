<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;

class PaymentController extends Controller
{
    

    public function processPayment(Request $request, String $product, $price){
        $user = Auth::user();
        $paymentMethod = $request->input('payment_method');
        $user->createOrGetStripeCustomer();
        $user->addPaymentMethod($paymentMethod);
        try{
          $user->charge($price*100, $paymentMethod);
        }
        catch (\Exception $e){
          return back()->withErrors(['message' => 'Error creating subscription. ' . $e->getMessage()]);
        }
         return redirect('/');
     }
}
