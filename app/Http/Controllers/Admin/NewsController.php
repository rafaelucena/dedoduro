<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\News;
use App\Http\Models\NewsFlagModel as NewsFlag;
use App\Http\Models\Party;
use App\Http\Models\PersonaNews;
use App\Http\Models\PersonaSlug;
use App\Http\Models\Politician;
use App\Http\Models\Persona;
use App\Http\Models\PoliticianRole;
use App\Http\Models\Source;
use App\Http\Requests\StorePolitician;
use App\Http\Requests\UpdateNews;
use Datetime;
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
        $trashedItemsAmount = count([]/*$this->em->getRepository(News::class)->findBy([
            'isActive' => 0,
            'isDeleted' => 1,
        ])*/);

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
                'nf.isActive',
                'nw.publishedAt',
                'so.name AS sourceName',
            ])
            ->from(News::class, 'nw')
            ->innerJoin( Source::class, 'so', 'WITH', 'so = nw.source')
            ->innerJoin( NewsFlag::class, 'nf', 'WITH', 'nf = nw.flags')
            ->where('nf.isDeleted = :isDeleted')
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
        /*/* @var News $news */
        $news = new News();
        /* @var Source[] $sources */
        $sources = $this->em->getRepository(Source::class)->findAll();

        $formHelper = new \stdClass();
        $formHelper->title = 'News - Insert';
        $formHelper->method = 'POST';
        $formHelper->action = route('news.store');
        $formHelper->submit = 'Create';

        return view(
            'admin/news/create',
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function store(UpdateNews $request)
    {
        $this->save($request);
        // Back to index with success
        return redirect()->route('news.index')->with('custom_success', 'Politician has been created successfully');
    }

    /**
     * @param UpdateNews $request
     * @param int|null $id
     */
    private function save(UpdateNews $request, $id = null)
    {
        // Get the item to update
        $news = new News();
        if ($id) {
            /* @var News $news */
            $news = $this->em->getRepository(News::class)->find($id);
        }
        /* @var Source $source */
        $source = $this->em->getRepository(Source::class)->find($request->source_id);

        // Store and Update Personas
        $this->updatePersonas($news, ['politicians' => $request->personas_politicians]);

        // Step 1 - Set News
        $news->url = $request->url;
        $news->title = $request->title;
        $news->description = $request->description;
        $news->publishedAt = new Datetime($request->published_at);
        $news->setSource($source);

        $this->em->persist($news);
        $this->em->flush();
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

        $formHelper = new \stdClass();
        $formHelper->title = 'News - Edit';
        $formHelper->method = 'PUT';
        $formHelper->action = route('news.update', $news->id);
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

    protected function update(UpdateNews $request, $id)
    {
        $this->save($request, $id);
        // Back to index with success
        return back()->with('custom_success', 'News has been updated successfully');
    }

    protected function newsAjaxSelect(Request $request)
    {
        //@TODO - Adapt this function for types, Politician, Lawman, etc.
        if ($request->ajax()) {
            $showMax = 3;
            $news = $this->em->createQueryBuilder()
                ->select([
                    'ne.id',
                    'ne.title',
                    'ne.url',
                ])
                ->from(News::class, 'ne')
                ->where('ne.title LIKE :term OR ne.url LIKE :term')
//                ->andWhere('ne.id NOT IN (:news)')
                ->orderBy('ne.title')
                ->setParameters([
//                    'news' => $request->news,
                    'term' => '%' . $request->term . '%',
                ])
                ->setMaxResults($showMax + 1)
                ->getQuery()
                ->getResult();

            $resultSelect2 = [];
            $count = 0;
            foreach ($news as $singleNews) {
                $resultSelect2[] = [
                    'id' => $singleNews['id'],
//                    'text' => '<del>' . $category->name . '</del>',
                    'text' => $request->type === 'title' ? $singleNews['title'] : $singleNews['url'],
                    'disabled' => $singleNews['id'] == $request->id ? false : true,
                ];

                $count++;
                if ($count >= $showMax) {
                    break;
                }
            }
            if (count($news) > $showMax) {
                $resultSelect2[] = [
                    'id' => '0',
                    'text' => 'Too many options, be more specific',
                    'disabled' => true,
                ];
            }

            return response()->json([
                'results' => $resultSelect2,
            ]);
        }
    }

    /**
     * @param Persona $persona
     * @param array $slugsInput
     */
    private function updatePersonas(News $news, array $personaGroups)
    {
        $currentPersonas = $news->getPersonaNews();
        $unusedPersonas = [];
        foreach ($currentPersonas as $currentPersona) {
            $unusedPersonas[$currentPersona->getPersona()->id] = $currentPersona;
        }

        foreach ($personaGroups as $personaGroup) {
            foreach ($personaGroup as $personaInput) {
                if (isset($unusedPersonas[$personaInput])) {
                    unset($unusedPersonas[$personaInput]);
                    continue;
                }

                /* @var Persona $persona */
                $persona = $this->em->getRepository(Persona::class)->find($personaInput);
                if (!$persona) {
                    return false;
                }

                $personaNews = $this->em->getRepository(PersonaNews::class)->findOneBy([
                    'persona' => $persona,
                    'news' => $news,
                ]);
                if (!$personaNews) {
                    $personaNews = new PersonaNews();
                    $personaNews->setNews($news);
                    $personaNews->setPersona($persona);
                }

                $personaNews->isActive = (int) true;
                $personaNews->isDeleted = (int) false;

                $this->em->persist($personaNews);
            }
        }

        foreach ($unusedPersonas as $unusedPersona) {
            $unusedPersona->isActive = (int) false;
            $unusedPersona->isDeleted = (int) true;
            $unusedPersona->deletedAt = new \DateTime();

            $this->em->persist($unusedPersona);
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
