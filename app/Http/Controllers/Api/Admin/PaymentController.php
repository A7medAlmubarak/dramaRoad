<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\OtherPaymentRequest;
use App\Http\Requests\Payment\SalaryPaymentRequest;
use App\Models\PaymentOther;
use App\Models\PaymentSalary;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexOtherPayment()
    {
        $payment = PaymentOther::latest()->get();
        return response()->json(['data'=> $payment ], 200) ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeOtherPayment(OtherPaymentRequest $request)
    {
        $inputs = $request->all();
        $payment = PaymentOther::create($inputs);
        return response()->json(['msg'=>'payment has been stored'], 200) ;

    }

    public function indexSalaryPayment(SalaryPaymentRequest $request)
    {
        $payment = PaymentSalary::latest()->get();
        return response()->json(['data'=> $payment ], 200) ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeSalaryPayment(SalaryPaymentRequest $request)
    {
        $inputs = $request->all();
        $payment = PaymentSalary::create($inputs);
        return response()->json(['msg'=>'payment has been stored'], 200) ;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
