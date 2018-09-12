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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs_count = count($this->em->getRepository(Blog::class)->findAll());
        $comments_count = count($this->em->getRepository(Comment::class)->findAll());
        $categories_count = count($this->em->getRepository(Category::class)->findAll());
        $users_count = count($this->em->getRepository(User::class)->findAll());

        return view('admin/dashboard', [
            'blogs_count' => $blogs_count,
            'comments_count' => $comments_count,
            'categories_count' => $categories_count,
            'users_count' => $users_count,
        ]);
    }
}
