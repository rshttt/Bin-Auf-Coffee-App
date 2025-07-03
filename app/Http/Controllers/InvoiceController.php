<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceProduct;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoice = Invoice::with(['products', 'user'])->get();
        
        return response()->json([
            'invoice' => $invoice
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|alpha_num|size:5|unique:invoices,code',
            'user_id' => 'required|exists:users,id',
            'delivery_cost' => 'nullable|integer|min:0',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|integer|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1'
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 422);
        }

        $invoice = Invoice::create([
            'code' => $request->code,
            'delivery_cost' => $request->delivery_cost ?? 0,
            'status' => 'ready',
            'user_id' => $request->user_id
        ]);

        foreach ($request->products as $item) {
            InvoiceProduct::create([
                'invoice_code' => $invoice->code,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
            ]);
        }

        return response()->json([
            'message' => 'Invoice baru berhasil ditambahkan!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $code)
    {
        $validator = Validator::make(['code' => $code], [
            'code' => 'required|alpha_num|size:5'
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 422);
        }

        $invoice = Invoice::with(['products', 'user'])->where('code', $code)->first();

        if (!$invoice) {
            return response()->json([
                'message' => 'Invoice tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'invoice' => $invoice
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function view(string $code)
    {
        $invoice = Invoice::with(['products', 'user'])->where('code', $code)->first();
        
        return view('invoice.view', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $code)
    {
        $validator = Validator::make(['code' => $code], [
            'code' => 'required|alpha_num|size:5'
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 422);
        }

        $invoice = Invoice::with('products')->where('code', $code)->first();

        if (!$invoice) {
            return response()->json([
                'message' => 'Invoice tidak ditemukan.'
            ], 404);
        }
        
        $old_status = $invoice->status;

        $status_order = ['ready', 'received', 'paid', 'served', 'delivered', 'done'];

        $current_index = array_search($old_status, $status_order);

        if(
            $current_index === false || 
            $current_index === count($status_order) - 1
        ) {
            return response()->json([
                'message' => 'Status tidak bisa diperbarui lagi!'
            ], 400);
        }

        $new_status = $status_order[$current_index + 1];

        $updated = $invoice->update([
            'status' => $new_status
        ]);

        if($updated === 0) {
            return response()->json([
                'message' => 'Invoice gagal di-update!',
            ], 400);
        }

        return response()->json([
            'message' => 'Invoice berhasil di-update!',
            'redirect' => '/invoices/' . $code . '/view'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}