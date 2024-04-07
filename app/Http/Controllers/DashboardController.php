<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Post $post)
    {
        $posts =  $post->orderBy('origin_date', 'desc')->get();
        return Inertia::render('Dashboard', ['posts' => $posts]);
    }

    public function delete(Post $post)
    {
        $post->deleted_by = auth()->id();
        $post->save();
        $post->delete();
    }
}
