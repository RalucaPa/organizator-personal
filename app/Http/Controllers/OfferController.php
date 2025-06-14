<?php

namespace App\Http\Controllers;
use App\Models\Offer;
use Inertia\Inertia;

use Illuminate\Http\Request;

class OfferController extends Controller
{

    public function index(Request $request)
    {
        $category = $request->get('category');
        $offers = Offer::when($category, fn($q) => $q->where('category', $category))->get();
        
        return Inertia::render('Offers/Index', ['offers' => $offers]);
    }

}
