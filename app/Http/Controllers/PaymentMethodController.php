<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentMethodStoreRequest;
use App\Http\Requests\PaymentMethodUpdateRequest;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $methods = PaymentMethod::latest()->paginate(25);
        return view('payment_methods.index', compact('methods'));
    }

    public function create()
    {
        return view('payment_methods.create');
    }

    public function store(PaymentMethodStoreRequest $request)
    {
        PaymentMethod::create($request->validated());

        return redirect()->route('payment-methods.index')->with('success', 'Payment method created successfully.');
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('payment_methods.edit', compact('paymentMethod'));
    }

    public function update(PaymentMethodUpdateRequest $request, PaymentMethod $paymentMethod)
    {
        $paymentMethod->update($request->validated());

        return redirect()->route('payment-methods.index')->with('success', 'Payment method updated successfully.');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();

        return redirect()->route('payment-methods.index')->with('success', 'Payment method deleted successfully.');
    }
}
