<?php

namespace App\Http\Controllers;

use App\Models\BookOrder;
use Illuminate\Http\Request;

class BookOrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|regex:/^03[0-9]{9}$/|size:11',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'pincode' => 'required|string|max:10',
            'payment_method' => 'required|in:cod,online'
        ], [
            'phone.regex' => 'Phone number must be a valid Pakistani mobile number starting with 03 (11 digits)',
            'phone.size' => 'Phone number must be exactly 11 digits'
        ]);

        BookOrder::create($validated);

        return redirect()->back()->with('success', 'Your order has been placed successfully! We will contact you soon.');
    }

    public function index()
    {
        $orders = BookOrder::orderBy('created_at', 'desc')->paginate(20);
        return view('book-orders.index', compact('orders'));
    }

    public function edit(BookOrder $bookOrder)
    {
        return view('book-orders.edit', compact('bookOrder'));
    }

    public function update(Request $request, BookOrder $bookOrder)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled,returned',
            'notes' => 'nullable|string'
        ]);

        $bookOrder->update($validated);

        return redirect()->route('book-orders.index')->with('success', 'Order updated successfully!');
    }

    public function destroy(BookOrder $bookOrder)
    {
        $bookOrder->delete();
        return redirect()->route('book-orders.index')->with('success', 'Order deleted successfully!');
    }
}
