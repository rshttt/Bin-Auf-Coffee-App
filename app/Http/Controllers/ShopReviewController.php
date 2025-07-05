<?php

namespace App\Http\Controllers;

use App\Models\ShopReview;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ShopReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shop_reviews = ShopReview::with('user')->get()->map(function($review) {
            $review->date = Carbon::parse($review->updated_at)->format('d/m/Y');
            return $review;
        });
        
        return response()->json([
            'shop_reviews' => $shop_reviews
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(!ctype_digit($id)) {
            abort(400, 'ID tidak valid');
        }

        $shop_review = ShopReview::find((int) $id);

        if (!$shop_review) {
            return response()->json([
                'message' => 'Review toko tidak ditemukan.'
            ], 404);
        }

        return view('shop_reviews.view', compact('shop_review'));
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
