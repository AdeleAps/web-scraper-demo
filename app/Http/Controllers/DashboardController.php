<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $posts =  Post::orderBy('origin_date', 'desc')->get();
        return Inertia::render('Dashboard', ['posts' => $posts]);
    }
}
