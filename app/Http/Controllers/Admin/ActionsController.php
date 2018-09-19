<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Action;
use App\Http\Models\PersonaSlug;
use App\Http\Models\Slug;
use App\Http\Models\User;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class ActionsController extends Controller
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
     * Select2 Actions - Process select2 ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    protected function actionsAjaxSelect(Request $request)
    {
        if ($request->ajax()) {
            $page = $request->page;
            $resultCount = 10;

            $offset = ($page - 1) * $resultCount;

            $actions = $this->em->createQueryBuilder()
                ->select([
                    'ac.id',
                    'ac.url',
                    'ac.title',
                    'ac.subtitle',
                    'ac.happenedAt',
                    'ac.isRelevant',
                    'ac.isActive AS actionActive',
                ])
                ->from(Action::class, 'ac')
                ->where('ac.title LIKE :term')
                ->orderBy('ac.title')
                ->setParameter('term', '%' . $request->term . '%')
                ->getQuery()
                ->getResult();

            $resultSelect2 = [];
            foreach ($actions as $action) {
                $disabled = false;

                if (!$action['actionActive']) {
                    $disabled = true;
                }

                $resultSelect2[] = [
                    'id' => $action['id'],
//                    'text' => '<del>' . $category->name . '</del>',
                    'text' => $action['title'],
                    'disabled' => $disabled,
                    'dataUrl' => $action['url'],
                    'dataSubtitle' => $action['subtitle'],
                    'dataHappenedAt' => $action['happenedAt']->format('d-m-Y H:i'),
                    'dataIsRelevant' => $action['isRelevant'],
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
