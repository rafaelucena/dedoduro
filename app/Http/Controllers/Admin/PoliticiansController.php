<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Blog;
use App\Http\Models\BlogCategory;
use App\Http\Models\Category;
use App\Http\Models\Party;
use App\Http\Models\Politician;
use App\Http\Models\Persona;
use App\Http\Models\PoliticianRole;
use App\Http\Requests\StoreBlogPost;
use App\Http\Requests\UpdateBlogPost;
use App\Http\Models\User;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;

class PoliticiansController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);

        $this->middleware('role:view_all_blog', ['only' => ['index', 'blogsData', 'trashed', 'blogsAjaxTrashedData']]);
        $this->middleware('role:view_blog', ['only' => ['show']]);
        $this->middleware('role:add_blog', ['only' => ['create','store']]);
        $this->middleware('role:edit_blog', ['only' => ['update', 'edit', 'updateActiveStatus']]);
        $this->middleware('role:delet_blog', ['only' => ['destroy', 'restore', 'permanentDelet', 'emptyTrash']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function index()
    {
        $trashedItemsAmount = count($this->em->getRepository(Politician::class)->findBy([
            'isActive' => 0,
            'isDeleted' => 1,
        ]));

//        $trashed_items = Blog::onlyTrashed()->count();
        return view('admin/politicians/index', ['trashed_items_count' => $trashedItemsAmount]);
    }

    /**
     * index blogs - Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getDatatable()
    {
        $politicians = $this->em->createQueryBuilder()
            ->select([
                'po.id',
                'pe.shortName as personaShortName',
                'pa.shortName as partyShortName',
                'po.isActive',
                'po.createdAt',
                'pr.name as politicianRoleName',
            ])
            ->from(Politician::class, 'po')
            ->innerJoin( Party::class, 'pa', 'WITH', 'po.party = pa')
            ->innerJoin( Persona::class, 'pe', 'WITH', 'po.persona = pe')
            ->innerJoin( PoliticianRole::class, 'pr', 'WITH', 'pr = po.role')
            ->where('po.isDeleted = :isDeleted')
            ->setParameter('isDeleted', (int) false)
            ->getQuery()
            ->getResult();

        return Datatables::of($politicians)
            ->addColumn('bulkAction', '<input type="checkbox" name="selected_ids[]" id="bulk_ids" value="{{ $id }}">')
            ->editColumn('politician.id', function ($model) {
                return $model['id'];
            })
            ->editColumn('persona.shortName', function ($model) {
                return $model['personaShortName'];
            })
            ->editColumn('party.shortName', function ($model) {
                return $model['partyShortName'];
            })
            ->editColumn('politicianRole.name', function ($model) {
                return $model['politicianRoleName'];
            })
            ->editColumn('politician.isActive', function ($model) {
                $divClass = 'text-success';
                $divValue = 'Yes';
                $iClass = 'fa-check';

                if ($model['isActive'] == 0) {
                    $divClass = 'text-danger';
                    $divValue = 'No';
                    $iClass = 'fa-times';
                }

                return vsprintf(
                    '<div class="%s">%s <span class="badge badge-light"><i class="fas %s"></i></span></div>',
                    [$divClass, $divValue, $iClass]
                );
            })
            ->editColumn('politician.createdAt', function ($model) {
                $createdAtTitle = $model['createdAt']->format('F d, Y @ h:i A');
                $createdAtValue = $model['createdAt']->format('F d, Y');
                return vsprintf(
                    '<abbr title="%s">%s</abbr>',
                    [$createdAtTitle, $createdAtValue]
                );
            })
            ->addColumn('actions', function ($model) {
                $route = route('blogs.publishStatus', $model['id']);
                $publishValue = 'Unpublish';
                $iClass = 'fa-times';

                if ($model['isActive'] == 0) {
                    $publishValue = 'Publish';
                    $iClass = 'fa-check';
                }

                $publish_action = vsprintf(
                    '<a class="dropdown-item" href="%s" onclick="return confirm(\'Are you sure?\')"><i class="fas %s"></i> %s</a>',
                    [$route, $iClass, $publishValue]
                );

                return '
                 <div class="dropdown float-right">
                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-cog"></i> Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="'.route('politician.get', $model['id']).'"><i class="fas fa-eye"></i> View</a>
                        <a class="dropdown-item" href="'.route('politician.put', $model['id']).'"><i class="fas fa-edit"></i> Edit</a>
                        '.$publish_action.'
                        <a class="dropdown-item text-danger" href="#" onclick="callDeletItem(\''.$model['id'].'\', \'blogs\');"><i class="fas fa-trash"></i> Trash</a>
                    </div>
                </div>';
            })
            ->rawColumns(['actions','user.name','politician.isActive','bulkAction','politician.createdAt'])
            ->make(true);
    }



    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function trashed()
    {
        $trashed_items = count($this->em->getRepository(Blog::class)->findBy(['isActive' => (int) false, 'isDeleted' => (int) true]));
//        $trashed_items = Blog::onlyTrashed()->count();
        return view('admin/blogs/trashed-index', ['trashed_items_count' => $trashed_items]);
    }

    /**
     * trashed blogs - Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function blogsAjaxTrashedData()
    {
        $blogs = $this->em->createQueryBuilder()
            ->select([
                'b.id',
                'b.title',
                'b.deletedAt',
                'u.id as userId',
                'u.name',
            ])
            ->from(Blog::class, 'b')
            ->innerJoin(User::class, 'u', 'WITH', 'b.user = u')
            ->where('b.isDeleted = :isDeleted')
            ->setParameter('isDeleted', (int) true)
            ->getQuery()
            ->getResult();
//        $blogs = Blog::join('users', 'blogs.user_id', '=', 'users.id')
//                        ->select(['blogs.id', 'blogs.title', 'blogs.user_id', 'users.name', 'blogs.deleted_at'])
//                        ->onlyTrashed();

        return Datatables::of($blogs)
                ->editColumn('trashed_at', function ($model) {
                    return $model['deletedAt']->format('F d, Y h:i A');
                })
                ->editColumn('users.name', function ($model) {
                    return '<a href="'.route('users.show', $model['userId']).'" class="link">'.$model['name'].' <i class="fas fa-external-link-alt"></i></a>';
                })
                ->addColumn('bulkAction', '<input type="checkbox" name="selected_ids[]" id="bulk_ids" value="{{ $id }}">')
                ->addColumn('actions', function ($model) {
                    return '
                     <div class="dropdown float-right">
                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-cog"></i> Action
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="'.route('blogs.restore', $model['id']).'" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-history"></i> Restore</a>
                            <a class="dropdown-item text-danger" href="'.route('blogs.permanentDelet', $model['id']).'" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-trash"></i> Permanent Delet</a>
                        </div>
                    </div>';
                })
                ->rawColumns(['actions','users.name','bulkAction'])
                ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function create()
    {
        $authors = $this->em->getRepository(User::class)->findAll();
//        $authors = User::active()->whereHas('roles', function ($query) {
//            $query->where('role', '=', 'add_blog');
//        })->get();

        return view('admin/blogs/create', ['authors' => $authors]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function store(StoreBlogPost $request)
    {
        // Pre Validations are done in StoreBlogPost Request
        // Store the item

        // Store File & Get Path
        $imagePath = Storage::putFile('images', $request->file('image'));


        // Step 1 - Init item Obj
        $blog = new Blog();

        // Store & Get Categories
        $this->updateBlogCategories($blog, $request->categories);

        // Set item fields
        $blog->title = $request->title;
        $blog->excerpt = $request->excerpt;
        $blog->description = $request->description;
        $blog->image = $imagePath;
        $blog->user = $this->em->getRepository(User::class)->find($request->user_id);
        $blog->isActive = $request->is_active;
        $blog->allowComments = $request->allow_comments;

        // Step 2 - Save Item
        $this->em->persist($blog);
        $this->em->flush();
//        $blog->save();

        // Step 3 - Attach/Sync Related Items
//        $blog->categories()->sync($categoryArr);

        // Back to index with success
        return redirect()->route('blogs.index')->with('custom_success', 'Blog has been added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function show($id)
    {
        $blog = $this->em->getRepository(Blog::class)->find($id);
//        $blog = Blog::findOrFail($id);
        return view('admin/blogs/show', ['blog' => $blog]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function edit($id)
    {
        // Politician Details
        $politician = $this->em->getRepository(Politician::class)->find($id);
        // Persona Details
        $persona = $politician->persona;
        // Party list
        $parties = $this->em->getRepository(Party::class)->findAll();
        // Roles List
        $roles = $this->em->getRepository(PoliticianRole::class)->findAll();

        return view(
            'admin/politicians/edit',
            ['politician' => $politician, 'persona' => $persona, 'parties' => $parties, 'roles' => $roles]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateBlogPost $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function update(UpdateBlogPost $request, $id)
    {
        // Pre Validations are done in UpdateBlogPost Request
        // Update the item

        // Get the item to update
        $blog = $this->em->getRepository(Blog::class)->find($id);
//        $blog = Blog::findOrFail($id);


        // Store File & Get Path
        if ($request->hasFile('image')) {
            $imagePath = Storage::putFile('images', $request->file('image'));
            // Delet Old Image
            Storage::delete($blog->image);
        } else {
            $imagePath = $blog->image;
        }

        // Store & Get Categories
        $this->updateBlogCategories($blog, $request->categories);

        // Step 1 - Set item fields
        $blog->title = $request->title;
        $blog->excerpt = $request->excerpt;
        $blog->description = $request->description;
        $blog->image = $imagePath;
        $blog->user = $this->em->getRepository(User::class)->find($request->user_id);
        $blog->isActive = $request->is_active;
        $blog->allowComments = $request->allow_comments;

        // Step 2 - Save Item
        $this->em->persist($blog);
        $this->em->flush();
//        $blog->save();

        // Step 3 - Attach/Sync Related Items
//        $blog->categories()->sync($categoryArr);

        // Back to index with success
        return back()->with('custom_success', 'Blog has been updated successfully');
    }

    /**
     * @param Blog $blog
     * @param array $categoriesInput
     */
    private function updateBlogCategories(Blog $blog, array $categoriesInput)
    {
        $currentBlogCategories = $blog->getCategories();
        $toDisableBlogCategories = [];
        foreach ($currentBlogCategories as $currentBlogCategory) {
            $toDisableBlogCategories[$currentBlogCategory->category->id] = $currentBlogCategory;
        }

        foreach ($categoriesInput as $categoryInput) {
            unset($toDisableBlogCategories[$categoryInput]);

            $category = $this->em->getRepository(Category::class)->find($categoryInput);
            if (!$category) {
                $category = new Category();
                $category->name = $categoryInput;
                $category->user = Auth::user();
                $this->em->persist($category);
            }

            $blogCategory = $this->em->getRepository(BlogCategory::class)->findOneBy([
                'blog' => $blog,
                'category' => $category,
            ]);
            if (!$blogCategory) {
                $blogCategory = new BlogCategory();
                $blogCategory->category = $category;
                $blogCategory->blog = $blog;
            }
            $blogCategory->isActive = (int) true;
            $blogCategory->deletedAt = null;
            $this->em->persist($blogCategory);
        }

        foreach ($toDisableBlogCategories as $toDisableBlogCategory) {
            $toDisableBlogCategory->isActive = (int) false;
            $toDisableBlogCategory->deletedAt = new \DateTime();

            $this->em->persist($toDisableBlogCategory);
        }
    }

    /**
     * Update the is active status of specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function updateActiveStatus($id)
    {
        // get all trashed blogs and permanent Delet the blogs
        $blog = $this->em->getRepository(Blog::class)->find($id);
//        $blog = Blog::findOrFail($id);

        if ($blog->isActive) {
            $blog->isActive = (int) false;
        } else {
            $blog->isActive = (int) true;
        }
        $this->em->persist($blog);
        $this->em->flush();
//        $status = $blog->save();

//        if ($status) {
            // If success
            return back()->with('custom_success', 'Blog publish status updated.');
//        } else {
//            // If no success
//            return back()->with('custom_errors', 'Failed to change publish status. Something went wrong.');
//        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function destroy($id)
    {
        // Find the blog by $id
        $blog = $this->em->getRepository(Blog::class)->find($id);
//        $blog = Blog::findOrFail($id);

        // Soft Delet the blog and transfer to Trash Items
        $blog->isActive = (int) false;
        $blog->isDeleted = (int) true;
        $blog->deletedAt = new \DateTime();
//        $blog->delete();

        $this->em->flush($blog);

//        if ($blog->trashed()) {
            // If success
            return back()->with('custom_success', 'Blog has been deleted and transfered to trash items.');
//        } else {
//            // If no success
//            return back()->with('custom_errors', 'Blog was not deleted. Something went wrong.');
//        }
    }

    /**
     * Bulk trash items in the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function bulkTrash(Request $request)
    {
        $arrId = explode(",", $request->ids);
        $status = Blog::destroy($arrId);

        if ($status) {
            // If success
            return back()->with('custom_success', 'Bulk Trash action completed.');
        } else {
            // If no success
            return back()->with('custom_errors', 'Bulk Trash action failed. Something went wrong.');
        }
    }

    /**
     * Restore the specified resource from trashed storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function restore($id)
    {
        // Find the blog by $id
        $blog = $this->em->getRepository(Blog::class)->findOneBy([
            'isDeleted' => (int) true,
            'id' => $id,
        ]);
//        $blog = Blog::onlyTrashed()->findOrFail($id);

        // Restore the blog
        $blog->isDeleted = (int) false;
        $blog->deletedAt = null;

        $this->em->persist($blog);
        $this->em->flush();
//        $blog->restore();

//        if (!$blog->trashed()) {
            // If success
            return back()->with('custom_success', 'Blog has been restored.');
//        } else {
            // If no success
//            return back()->with('custom_errors', 'Blog was not able to restore. Something went wrong.');
//        }
    }

    /**
     * Bulk Restore items in the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function bulkRestore(Request $request)
    {
        $arrId = explode(",", $request->ids);
        $status = Blog::onlyTrashed()->restore($arrId);

        if ($status) {
            // If success
            return back()->with('custom_success', 'Bulk Restore action completed.');
        } else {
            // If no success
            return back()->with('custom_errors', 'Bulk Restore action failed. Something went wrong.');
        }
    }

    /**
     * Permanent Delet the specified resource from trashed storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function permanentDelet($id)
    {
        // Find the blog by $id
        $blog = Blog::onlyTrashed()->findOrFail($id);

        // Delete Related Items First
        $blog->categories()->detach();
        $blog->comments()->delete();
        // Delete Image
        Storage::delete($blog->image);

        // Permanent Delet the blog
        $status = $blog->forceDelete();

        if ($status) {
            // If success
            return back()->with('custom_success', 'Blog has been deleted permanently.');
        } else {
            // If no success
            return back()->with('custom_errors', 'Blog was not able to deleted permanently. Something went wrong.');
        }
    }

    /**
     * permanent delet all trashed items in the specified resource from trashed storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function emptyTrash()
    {
        // get all trashed blogs and permanent Delet the blogs
        $blogs = Blog::onlyTrashed()->get();

        foreach ($blogs as $blog) {
            // Delete Related Items First
            $blog->categories()->detach();
            $blog->comments()->delete();
            // Delete Image
            Storage::delete($blog->image);
            Auth::user();
            // Delete Blog
            $blog->forceDelete();
        }

        return back()->with('custom_success', 'Trash has been emptied.');
    }
}
