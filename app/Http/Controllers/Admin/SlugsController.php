<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\PersonaSlug;
use App\Http\Models\Slug;
use App\Http\Models\User;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class SlugsController extends Controller
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
     *  Select2 categories - Process select2 ajax request.
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    protected function slugsAjaxSelect(Request $request)
    {
        if ($request->ajax()) {
            $page = $request->page;
            $resultCount = 10;

            $offset = ($page - 1) * $resultCount;

            $slugs = $this->em->createQueryBuilder()
                ->select([
                    's.id',
                    's.name',
                    's.isActive AS slugActive',
                    'ps.isActive AS personActive',
                ])
                ->from(Slug::class, 's')
                ->leftJoin(PersonaSlug::class, 'ps', 'WITH', 'ps.slug = s')
                ->where('s.name LIKE :term')
                ->orderBy('s.name')
                ->setParameter('term', '%' . $request->term . '%')
                ->getQuery()
                ->getResult();

            $resultSelect2 = [];
            foreach ($slugs as $slug) {
                $disabled = false;

                if ($slug['personActive']) {
                    $disabled = true;
                }

                $resultSelect2[] = [
                    'id' => $slug['id'],
//                    'text' => '<del>' . $category->name . '</del>',
                    'text' => $slug['name'],
                    'disabled' => $disabled,
                ];
            }

            $count = count($resultSelect2);

            $endCount = $offset + $resultCount;
            $morePages = $count > $endCount;

            $results = [
                "results" => $resultSelect2,
                "pagination" => [
                    "more" => $morePages,
                ]
            ];
            return response()->json($results);
        }
    }
}
