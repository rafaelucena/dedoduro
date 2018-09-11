<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Http\Models\Blog;
use App\Http\Models\Category;
use App\Http\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogsController extends Controller
{
    /**
     * Show the Single Blog.
     *
     * @return \Illuminate\Http\Response
     */
    public function single(Blog $blog)
    {
        // Increase Views of blog
        $blog->views = $blog->views + 1;

        $this->em->persist($blog);
        $this->em->flush();

        // Get Comments
        $comments = $blog->comments;
//        $comments = $blog->comments()->active()
//                                    ->orderBy('created_at', 'desc')
//                                    ->simplePaginate(app('global_settings')[3]->settingValue);
        // Get Count of Comments
        $total_comments = count($comments);

        // Return View
        return view('guest/single', ['blog' => $blog, 'comments' => $comments,  'total_comments' => $total_comments]);
    }

    /**
     * Show the blogs by category.
     *
     * @return \Illuminate\Http\Response
     */
    public function category(Category $category)
    {
//        $test = $this->em->getRepository(Category::class)->findBy(['slug' => 'etc']);
        $blogs = $category->blogs()->active()
                                ->orderBy('created_at', 'desc')
                                ->simplePaginate(app('global_settings')[2]->settingValue);
        return view('guest/category', ['blogs'=> $blogs, 'category' => $category]);
    }

    /**
     * Add comment on a blog.
     *
     * @return \Illuminate\Http\Response
     */
    public function comment(Request $request)
    {
        // Validate data
        $validatedData = $request->validate([
            'name' => 'bail|required|max:150',
            'email' => 'required|email',
            'body' => 'required|max:600',
        ]);

        // Get Blog by slug
        $blog_slug = explode('/', url()->previous());
        $blog = Blog::where('slug', end($blog_slug))->select('id')->firstOrFail();

        // If blog found
        if (!empty($blog)) {
            // Check status of validation
            if ($validatedData) {
                // Save Comment
                $comment = new Comment;
                $comment->name = $request->name;
                $comment->email = $request->email;
                $comment->body = $request->body;
                $comment->blog_id = $blog->id;
                $comment->save();

                // Redirect back with success
                return back()->with('custom_success', 'Your comment added successfully');
            }
        }
        // Redirect back with error
        return back()->withInput()->with('custom_errors', 'Unable to add comment');
    }


    /**
     * Search the blogs.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Search Query
        $query = $request->q;
        if ($query == '') {
            return redirect('/');
        }

        // Get blogs by Search Query and active ones
        $qb = $this->em->createQueryBuilder();
        $blogs = $qb->select('b')
            ->from(Blog::class, 'b')
            ->where('b.isActive = 1')
            ->andWhere('(b.title LIKE :query) OR (b.excerpt LIKE :query)')
            ->orderBy('b.createdAt', 'desc')
            ->setParameter('query', $query)
            ->getQuery()
            ->getResult();
//        $blogs = Blog::like('title', $query)
//                        ->orLike('excerpt', $query)
//                        ->active()
//                        ->orderBy('created_at', 'desc')
//                        ->simplePaginate(app('global_settings')[2]->settingValue);
        // Return View
        return view('guest/search', ['blogs' => $blogs, 'query' => $query]);
    }
}
