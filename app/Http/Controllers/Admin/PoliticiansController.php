<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Action;
use App\Http\Models\Blog;
use App\Http\Models\BlogCategory;
use App\Http\Models\Category;
use App\Http\Models\Party;
use App\Http\Models\PersonaAction;
use App\Http\Models\PersonaActionType;
use App\Http\Models\PersonaSlug;
use App\Http\Models\Politician;
use App\Http\Models\Persona;
use App\Http\Models\PoliticianRole;
use App\Http\Models\Slug;
use App\Http\Requests\StoreBlogPost;
use App\Http\Models\User;
use App\Http\Requests\StorePolitician;
use App\Http\Requests\UpdatePolitician;
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

    protected function personasAjaxSelect(Request $request)
    {
        //@TODO - Adapt this function for types, Politician, Lawman, etc.
        if ($request->ajax()) {
            $personas = $this->em->createQueryBuilder()
                ->select([
                    'pe.id',
                    'pe.firstName',
                    'pe.lastName',
                    'pe.isActive AS personaActive',
                ])
                ->from(Persona::class, 'pe')
                ->leftJoin(Politician::class, 'po', 'WITH', 'po.persona = pe')
                ->where('pe.firstName LIKE :term OR pe.lastName LIKE :term OR pe.shortName LIKE :term')
                ->orderBy('pe.firstName, pe.lastName')
                ->setParameter('term', '%' . $request->term . '%')
                ->getQuery()
                ->getResult();

            $resultSelect2 = [];
            foreach ($personas as $persona) {
                $disabled = false;

                if (!$persona['personaActive']) {
                    $disabled = true;
                }

                $resultSelect2[] = [
                    'id' => $persona['id'],
//                    'text' => '<del>' . $category->name . '</del>',
                    'text' => $persona['firstName'] . ' ' . $persona['lastName'],
                    'disabled' => $disabled,
                ];
            }

            return response()->json([
                'results' => $resultSelect2,
            ]);
        }
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
        $formHelper->method = 'POST';
        $formHelper->select2Helper = $select2Helper;
        $formHelper->submit = 'Create';

        return view(
//            'admin/politicians/create',
            'admin/politicians/save',
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
        $imagePath = 'images/default-male-square_195-195.png';
        if ($request->file('image')) {
            $imagePath = storage_put('images', $request->file('image'));
        }

        // Step 1 - Set Persona
        $persona = new Persona();
        $persona->shortName = $request->short_name;
        $persona->firstName = $request->first_name;
        $persona->lastName = $request->last_name;
        $persona->description = $request->description;
        $persona->image = $imagePath;
        $this->em->persist($persona);

        // Store and Update Slugs
        $this->updateSlugs($persona, $request->slugs);

        // Step 2 - Save Politician
        $politician = new Politician();
        $politician->persona = $persona;
        $politician->isRoleStill = (int) $request->is_role_still;
        $politician->isActive = $request->is_active;
        $politician->setParty($this->em->getRepository(Party::class)->find($request->party_id));
        $politician->setRole($this->em->getRepository(PoliticianRole::class)->find($request->role_id));

        if ($request->role_wish_id){
            $politician->setRoleWish($this->em->getRepository(PoliticianRole::class)->find($request->role_wish_id));
        }
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
        // Politician Details
        $politician = $this->em->getRepository(Politician::class)->find($id);
        // Persona Details
        $persona = $politician->persona;
        // Party list
        $parties = $this->em->getRepository(Party::class)->findAll();
        // Roles List
        $roles = $this->em->getRepository(PoliticianRole::class)->findAll();

        $select2Helper = new \stdClass();
        $select2Helper->placeholder = 'Update slugs...';
        $select2Helper->ajaxUrl = route('slugs.ajaxSelect');
        $select2Helper->allowDynamicOption = true;

        $formHelper = new \stdClass();
        $formHelper->title = 'Politicians - Edit';
        $formHelper->action = route('politicians.update', $politician->id);
        $formHelper->method = 'PUT';
        $formHelper->select2Helper = $select2Helper;
        $formHelper->submit = 'Update';

        return view(
            'admin/politicians/save',
//            'admin/politicians/edit',
            [
                // Helpers
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

        // Store and update actions
        $this->updateActions($persona, $request->action);

        // Step 1 - Set Persona
        $persona->shortName = $request->short_name;
        $persona->firstName = $request->first_name;
        $persona->lastName = $request->last_name;
        $persona->description = $request->description;
        $persona->image = $imagePath;
        $this->em->persist($persona);

        // Step 2 - Save Politician
        $politician->isRoleStill = (int) $request->is_role_still;
        $politician->isActive = $request->is_active;
        $politician->setParty($this->em->getRepository(Party::class)->find($request->party_id));
        $politician->setRole($this->em->getRepository(PoliticianRole::class)->find($request->role_id));

        if ($request->role_wish_id){
            $politician->setRoleWish($this->em->getRepository(PoliticianRole::class)->find($request->role_wish_id));
        }

        $this->em->persist($politician);

        $this->em->flush();
//        $blog->save();

        // Step 3 - Attach/Sync Related Items
//        $blog->categories()->sync($categoryArr);

        // Back to index with success
        return redirect()->route('politicians.index')->with('custom_success', 'Politician has been edited successfully');
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

        $count = 0;
        foreach ($slugsInput as $slugInput) {
            unset($unusedPersonaSlugs[$slugInput]);

            $slug = $this->em->getRepository(Slug::class)->find($slugInput);
            if (!$slug) {
                $slug = new Slug();
                $slug->name = $slugInput;
                $slug->slug = strslug($slugInput);
                $slug->createdBy = auth()->user();
            }
            $slug->isCanonical = $count === 0 ? (int) true : (int) false;
            $this->em->persist($slug);

            $personaSlug = $this->em->getRepository(PersonaSlug::class)->findOneBy([
//                'persona' => $persona,
                'slug' => $slug,
                'isActive' => (int) true,
            ]);
            if (!$personaSlug) {
                $personaSlug = new PersonaSlug();
                $personaSlug->slug = $slug;
                $personaSlug->setPersona($persona);
            }
            $personaSlug->isActive = (int) true;
            $personaSlug->deletedAt = null;
            $this->em->persist($personaSlug);
            $count++;
        }

        foreach ($unusedPersonaSlugs as $unusedPersonaSlug) {
            $unusedPersonaSlug->isActive = (int) false;
            $unusedPersonaSlug->deletedAt = new \DateTime();

            $this->em->persist($unusedPersonaSlug);
        }
    }

    private function updateActions(Persona $persona, $actionInput)
    {
        foreach ($actionInput['id'] as $key => $id) {
            $action = new Action();
            if ($id !== null) {
                $action = $this->em->getRepository(Action::class)->find($id);
            }
            $action->title = $actionInput['title'][$key];
            $action->subtitle = $actionInput['subtitle'][$key];
            $action->url = $actionInput['url'][$key];
            $action->isRelevant = $actionInput['is_relevant'][$key];
            $action->isActive = $actionInput['is_active'][$key];
            $action->happenedAt = new \DateTime($actionInput['happened_at'][$key]);
            $this->em->persist($action);

            $personaAction = false;
            if ($id !== null) {
                $personaAction = $persona->getPersonaAction($action);
            }
            if (!$personaAction) {
                $personaAction = new PersonaAction();
                $personaAction->setPersona($persona);
                $personaAction->setAction($action);
            }
            /* @var PersonaActionType $personaActionType */
            $personaActionType = $this->em->getRepository(PersonaActionType::class)->find($actionInput['person_type_id'][$key]);
            $personaAction->setPersonaActionType($personaActionType);
            $this->em->persist($personaAction);
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
