<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Category;
use App\Http\Models\Source;
use App\Http\Models\User;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class SourcesController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);

        $this->middleware('role:view_all_category', ['only' => ['index','categoriesData']]);
        $this->middleware('role:view_category', ['only' => ['show']]);

        $this->middleware('role:add_category', ['only' => ['create', 'store']]);

        $this->middleware('role:edit_category', ['only' => ['update', 'edit']]);

        $this->middleware('role:delet_category', ['only' => ['destroy', 'bulkDelete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin/sources/index');
    }

    /**
     * index categories - Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sourcesData()
    {
        $sources = $this->em->createQueryBuilder()
            ->select([
                'so.id',
                'so.name',
                'so.createdAt',
                'us.id as userId',
                'us.name as userName',
            ])
            ->from(Source::class, 'so')
            ->innerJoin(User::class, 'us', 'WITH', 'us = so.createdBy')
            ->getQuery()
            ->getResult();
//        $categories = Category::join('users', 'categories.user_id', '=', 'users.id')
//                        ->select(['categories.id', 'categories.name AS category_name', 'categories.user_id', 'users.name', 'categories.created_at']);

        return Datatables::of($sources)
                ->editColumn('source_name', function ($model) {
                    return $model['name'];
                })
                ->editColumn('created_at', function ($model) {
                    return "<abbr title='".$model['createdAt']->format('F d, Y @ h:i A')."'>".$model['createdAt']->format('F d, Y')."</abbr>";
                })
                ->editColumn('users.name', function ($model) {
                    return '<a href="'.route('users.show', $model['userId']).'" class="link">'.$model['userName'].' <i class="fas fa-external-link-alt"></i></a>';
                })
                ->addColumn('bulkAction', '<input type="checkbox" name="selected_ids[]" id="bulk_ids" value="{{ $id }}">')
                ->addColumn('actions', function ($model) {
                    return '
                     <div class="dropdown float-right">
                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-cog"></i> Action
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="'.route('sources.show', $model['id']).'"><i class="fas fa-eye"></i> View</a>
                            <a class="dropdown-item" href="'.route('sources.edit', $model['id']).'"><i class="fas fa-edit"></i> Edit</a>
                            <a class="dropdown-item text-danger" href="#" onclick="callDeletItem(\''.$model['id'].'\', \'sources\');"><i class="fas fa-trash"></i> Delete</a>
                        </div>
                    </div>';
                })
                ->rawColumns(['actions','users.name','bulkAction','created_at'])
                ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $source = new Source();

        $formHelper = new \stdClass();
        $formHelper->title = 'Sources - New';
        $formHelper->action = route('sources.store');
        $formHelper->method = 'POST';
        $formHelper->submit = 'Create';

        return view('admin/sources/create', [
            'formHelper' => $formHelper,
            'source' => $source,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validations
        $validatedData = $request->validate([
            'name' => 'required|unique:\App\Http\Models\Source|max:150',
        ]);

        // If validations fail
        if (!$validatedData) {
            return redirect()->back()
                    ->withErrors($validator)->withInput();
        }

        // Store the item
        $source = new Source();
        $source->name = $request->name;
        $source->shortName = $request->short_name;
        $source->url = $request->url;
        $source->isActive = $request->is_active;

        $this->em->persist($source);
        $this->em->flush();
//        $category->save();

        // Back to index with success
        return redirect()->route('sources.index')->with('custom_success', 'Source has been added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->em->getRepository(Category::class)->find($id);
//        $category = Category::findOrFail($id);
        return view('admin/sources/show', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $source = $this->em->getRepository(Source::class)->find($id);

        $formHelper = new \stdClass();
        $formHelper->title = 'Sources - Edit';
        $formHelper->action = route('sources.update', ['id' => $id]);
        $formHelper->method = 'PUT';
        $formHelper->submit = 'Update';

        return view('admin/sources/edit', [
            'source' => $source,
            'formHelper' => $formHelper,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validations
        $validatedData = $request->validate([
            'name' => 'required|max:150',
        ]);

        // If validations fail
        if (!$validatedData) {
            return redirect()->back()
                    ->withErrors($validator)->withInput();
        }

        // Update the item
        /* @var Source $source */
        $source = $this->em->getRepository(Source::class)->find($id);
        $source->name = $request->name;
        $source->shortName = $request->short_name;
        $source->url = $request->url;
        $source->isActive = $request->is_active;

        $this->em->persist($source);
        $this->em->flush();

        // Back to index with success
        return redirect()->route('sources.index')->with('custom_success', 'Source has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the category by $id
        $category = Category::findOrFail($id);

        // Foreign Key Error Protection
        if ($category->blogs()->count() > 0) {
            return back()->with('custom_errors', 'Category was not deleted. It is already attached with some blogs.');
        }

        // permanent delete
        $status = $category->delete();

        if ($status) {
            // If success
            return back()->with('custom_success', 'Category has been deleted.');
        } else {
            // If no success
            return back()->with('custom_errors', 'Category was not deleted. Something went wrong.');
        }
    }

    /**
     * Bulk delete items in the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function bulkDelete(Request $request)
    {
        $arrId = explode(",", $request->ids);

        // Foreign Key Error Protection
        $categories = Category::find($arrId);
        foreach ($categories as $category) {
            if ($category->blogs()->count() > 0) {
                return back()->with('custom_errors', '<b>'.$category->name. '</b>: It is already attached with some blogs. Categories were not deleted');
            }
        }

        // If no Foreign Key Error
        $status = Category::destroy($arrId);

        if ($status) {
            // If success
            return back()->with('custom_success', 'Bulk Delete action completed.');
        } else {
            // If no success
            return back()->with('custom_errors', 'Bulk Delete action failed. Something went wrong.');
        }
    }
}
