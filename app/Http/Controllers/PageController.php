<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        $categories = Category::all();

        return view('home', [
            'title' => 'Beranda',
            'categories' => $categories,
        ]);
    }
}
