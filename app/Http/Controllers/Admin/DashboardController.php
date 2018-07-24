<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Blog;
use App\Http\Models\Category;
use App\Http\Models\Comment;
use App\Http\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs_count = Blog::count();
        $comments_count = Comment::count();
        $categories_count = Category::count();
        $users_count = User::count();

        return view('admin/dashboard', [
            'blogs_count' => $blogs_count,
            'comments_count' => $comments_count,
            'categories_count' => $categories_count,
            'users_count' => $users_count,
        ]);
    }
}
