<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\News;
use App\Http\Models\Party;
use App\Http\Models\PersonaNews;
use App\Http\Models\PersonaSlug;
use App\Http\Models\Politician;
use App\Http\Models\Persona;
use App\Http\Models\PoliticianRole;
use App\Http\Models\Source;
use App\Http\Requests\StorePolitician;
use App\Http\Requests\UpdatePolitician;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class NewsController extends Controller
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
        $trashedItemsAmount = count($this->em->getRepository(News::class)->findBy([
            'isActive' => 0,
            'isDeleted' => 1,
        ]));

        return view('admin/news/index', ['trashed_items_count' => $trashedItemsAmount]);
    }

    /**
     * index news - Process datatables ajax request.
     *
     * @return mixed
     * @throws \Exception
     */
    protected function getDatatable()
    {
        $news = $this->em->createQueryBuilder()
            ->select([
                'nw.id',
                'nw.title',
                'nw.isActive',
                'nw.publishedAt',
                'so.name AS sourceName',
//                'pe.shortName as personaShortName',
//                'pa.shortName as partyShortName',
//                'po.isActive',
//                'po.createdAt',
//                'pr.name as politicianRoleName',
            ])
            ->from(News::class, 'nw')
            ->innerJoin( Source::class, 'so', 'WITH', 'so = nw.source')
            ->where('nw.isDeleted = :isDeleted')
            ->setParameter('isDeleted', (int) false)
            ->getQuery()
            ->getResult();

        return Datatables::of($news)
            ->addColumn('bulkAction', '<input type="checkbox" name="selected_ids[]" id="bulk_ids" value="{{ $id }}">')
            ->editColumn('news.id', function ($model) {
                return $model['id'];
            })
            ->editColumn('news.title', function ($model) {
                return $model['title'];
            })
            ->editColumn('news.publishedAt', function ($model) {
                $dateTitle = $model['publishedAt']->format('F d, Y @ h:i A');
                $dateValue = $model['publishedAt']->format('F d, Y');

                return vsprintf(
                    '<abbr title="%s">%s</abbr>',
                    [$dateTitle, $dateValue]
                );
            })
            ->editColumn('news.type', function ($model) {
                return 'vish';
            })
            ->editColumn('source.name', function ($model) {
                return $model['sourceName'];
            })
            ->editColumn('news.isActive', function ($model) {
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
            ->addColumn('actions', function ($model) {
                $route = route('news.publishStatus', $model['id']);
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
                        <a class="dropdown-item" href="'.route('news.get', $model['id']).'"><i class="fas fa-eye"></i> View</a>
                        <a class="dropdown-item" href="'.route('news.put', $model['id']).'"><i class="fas fa-edit"></i> Edit</a>
                        '.$publish_action.'
                        <a class="dropdown-item text-danger" href="#" onclick="callDeletItem(\''.$model['id'].'\', \'blogs\');"><i class="fas fa-trash"></i> Trash</a>
                    </div>
                </div>';
            })
            ->rawColumns(['actions','user.name','news.isActive','bulkAction','news.publishedAt'])
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
//    protected function blogsAjaxTrashedData()
//    {
//        $blogs = $this->em->createQueryBuilder()
//            ->select([
//                'b.id',
//                'b.title',
//                'b.deletedAt',
//                'u.id as userId',
//                'u.name',
//            ])
//            ->from(Blog::class, 'b')
//            ->innerJoin(User::class, 'u', 'WITH', 'b.user = u')
//            ->where('b.isDeleted = :isDeleted')
//            ->setParameter('isDeleted', (int) true)
//            ->getQuery()
//            ->getResult();
////        $blogs = Blog::join('users', 'blogs.user_id', '=', 'users.id')
////                        ->select(['blogs.id', 'blogs.title', 'blogs.user_id', 'users.name', 'blogs.deleted_at'])
////                        ->onlyTrashed();
//
//        return Datatables::of($blogs)
//                ->editColumn('trashed_at', function ($model) {
//                    return $model['deletedAt']->format('F d, Y h:i A');
//                })
//                ->editColumn('users.name', function ($model) {
//                    return '<a href="'.route('users.show', $model['userId']).'" class="link">'.$model['name'].' <i class="fas fa-external-link-alt"></i></a>';
//                })
//                ->addColumn('bulkAction', '<input type="checkbox" name="selected_ids[]" id="bulk_ids" value="{{ $id }}">')
//                ->addColumn('actions', function ($model) {
//                    return '
//                     <div class="dropdown float-right">
//                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
//                        <i class="fas fa-cog"></i> Action
//                        </button>
//                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
//                            <a class="dropdown-item" href="'.route('blogs.restore', $model['id']).'" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-history"></i> Restore</a>
//                            <a class="dropdown-item text-danger" href="'.route('blogs.permanentDelet', $model['id']).'" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-trash"></i> Permanent Delet</a>
//                        </div>
//                    </div>';
//                })
//                ->rawColumns(['actions','users.name','bulkAction'])
//                ->make(true);
//    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function create()
    {
        // Politician Details
        $politician = new Politician();
        // Persona Details
        $persona = new Persona();
        // Party list
        $parties = $this->em->getRepository(Party::class)->findAll();
        // Roles List
        $roles = $this->em->getRepository(PoliticianRole::class)->findAll();

        $select2Helper = new \stdClass();
        $select2Helper->placeholder = 'Create slugs...';
        $select2Helper->ajaxUrl = route('slugs.ajaxSelect');
        $select2Helper->allowDynamicOption = true;

        $formHelper = new \stdClass();
        $formHelper->title = 'Politicians - New';
        $formHelper->action = route('politicians.store');
        $formHelper->select2Helper = $select2Helper;
        $formHelper->submit = 'Create';

        return view(
            'admin/politicians/create',
            [
                // Helper
                'formHelper' => $formHelper,
                // Objects
                'parties' => $parties,
                'persona' => $persona,
                'politician' => $politician,
                'roles' => $roles,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function store(StorePolitician $request)
    {
        // Pre Validations are done in StoreBlogPost Request
        // Store File & Get Path
        $imagePath = storage_put('images', $request->file('image'));

        // Step 1 - Set Persona
        $persona = new Persona();
        $persona->shortName = $request->short_name;
        $persona->firstName = $request->first_name;
        $persona->lastName = $request->last_name;
        $persona->description = $request->description;
        $persona->image = $imagePath;
        $persona->isActive = $request->is_active;
        $this->em->persist($persona);

        // Step 2 - Save Politician
        $politician = new Politician();
        $politician->persona = $persona;
        $politician->party = $this->em->getRepository(Party::class)->find($request->party_id);
        $politician->role = $this->em->getRepository(PoliticianRole::class)->find($request->role_id);
        $this->em->persist($politician);

        // Step 3 - Flush everything
        $this->em->flush();

        // Back to index with success
        return redirect()->route('politicians.index')->with('custom_success', 'Politician has been created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function show($id)
    {
        $politician = $this->em->getRepository(Politician::class)->find($id);

        $persona = $politician->persona;

        $blog = $this->em->getRepository(Blog::class)->find($id);
//        $blog = Blog::findOrFail($id);
        return view('admin/politicians/show', ['politician' => $politician, 'persona' => $persona, 'blog' => $blog]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function edit($id)
    {
        /* @var News $news */
        $news = $this->em->getRepository(News::class)->find($id);
        /* @var Source[] $sources */
        $sources = $this->em->getRepository(Source::class)->findAll();

        $select2Helper = new \stdClass();
        $select2Helper->placeholder = 'Update slugs...';
        $select2Helper->ajaxUrl = route('slugs.ajaxSelect');
        $select2Helper->allowDynamicOption = false;

        $formHelper = new \stdClass();
        $formHelper->title = 'News - Edit';
        $formHelper->action = route('news.update', $news->id);
        $formHelper->select2Helper = $select2Helper;
        $formHelper->submit = 'Update';

        return view(
            'admin/news/edit',
            [
                // Helpers
                'formHelper' => $formHelper,
                // Objects
                'news' => $news,
                'sources' => $sources,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePolitician $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function update(UpdatePolitician $request, $id)
    {
        // Pre Validations are done in UpdateBlogPost Request
        // Update the item

        // Get the item to update
        /* @var Politician $politician */
        $politician = $this->em->getRepository(Politician::class)->find($id);
        /** $persona Persona **/
        $persona = $politician->persona;
//        $blog = Blog::findOrFail($id);

        // Store File & Get Path
        $imagePath = $persona->image;
        if ($request->hasFile('image')) {
            $imagePath = storage_put('images', $request->file('image'));
            // Delet Old Image
            storage_del($persona->image);
        }

        // Store and Update Slugs
        $this->updateSlugs($persona, $request->slugs);

        // Step 1 - Set Persona
        $persona->shortName = $request->short_name;
        $persona->firstName = $request->first_name;
        $persona->lastName = $request->last_name;
        $persona->description = $request->description;
        $persona->image = $imagePath;
        $persona->isActive = $request->is_active;
        $this->em->persist($persona);

        // Step 2 - Save Politician
        $politician->setParty($this->em->getRepository(Party::class)->find($request->party_id));
        $politician->setRole($this->em->getRepository(PoliticianRole::class)->find($request->role_id));
        $this->em->persist($politician);

        $this->em->flush();
//        $blog->save();

        // Step 3 - Attach/Sync Related Items
//        $blog->categories()->sync($categoryArr);

        // Back to index with success
        return back()->with('custom_success', 'Blog has been updated successfully');
    }

    /**
     * @param Persona $persona
     * @param array $slugsInput
     */
    private function updateSlugs(Persona $persona, array $slugsInput)
    {
        $currentPersonaSlugs = $persona->getSlugs();
        $unusedPersonaSlugs = [];
        foreach ($currentPersonaSlugs as $currentSlug) {
            $unusedPersonaSlugs[$currentSlug->slug->id] = $currentSlug;
        }

        foreach ($slugsInput as $slugInput) {
            unset($unusedPersonaSlugs[$slugInput]);

            $slug = $this->em->getRepository(Slug::class)->find($slugInput);
            if (!$slug) {
                $slug = new Slug();
                $slug->name = $slugInput;
                $slug->slug = strslug($slugInput);
                $slug->createdBy = auth()->user();
                $this->em->persist($slug);
            }

            $personaSlug = $this->em->getRepository(PersonaSlug::class)->findOneBy([
//                'persona' => $persona,
                'slug' => $slug,
                'isActive' => (int) true,
            ]);
            if (!$personaSlug) {
                $personaSlug = new PersonaSlug();
                $personaSlug->slug = $slug;
                $personaSlug->persona = $persona;
            }
            $personaSlug->isActive = (int) true;
            $personaSlug->deletedAt = null;
            $this->em->persist($personaSlug);
        }

        foreach ($unusedPersonaSlugs as $unusedPersonaSlug) {
            $unusedPersonaSlug->isActive = (int) false;
            $unusedPersonaSlug->deletedAt = new \DateTime();

            $this->em->persist($unusedPersonaSlug);
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

        $blog->isActive = (int) false;
        if (!$blog->isActive) {
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
        $status = 1/*Blog::destroy($arrId)*/;

        if (!$status) {
            // If no success
            return back()->with('custom_errors', 'Bulk Trash action failed. Something went wrong.');
        }

        // If success
        return back()->with('custom_success', 'Bulk Trash action completed.');
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

        if (!$status) {
            // If no success
            return back()->with('custom_errors', 'Bulk Restore action failed. Something went wrong.');
        }
        // If success
        return back()->with('custom_success', 'Bulk Restore action completed.');
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
        storage_del($blog->image);

        // Permanent Delet the blog
        $status = $blog->forceDelete();

        if (!$status) {
            // If no success
            return back()->with('custom_errors', 'Blog was not able to deleted permanently. Something went wrong.');
        }
        // If success
        return back()->with('custom_success', 'Blog has been deleted permanently.');
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
        $blogs = []/*Blog::onlyTrashed()->get()*/;

        foreach ($blogs as $blog) {
            // Delete Related Items First
            $blog->categories()->detach();
            $blog->comments()->delete();
            // Delete Image
            storage_del($blog->image);
            // Delete Blog
            $blog->forceDelete();
        }

        return back()->with('custom_success', 'Trash has been emptied.');
    }
}
