<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Models\News;
use App\Http\Models\NewsFlagModel as NewsFlag;
use App\Http\Models\Source;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class NewController extends BaseController
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

        return view('admin/news/index-new', ['trashed_items_count' => $trashedItemsAmount]);
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
                'nf.isImported',
                'nf.isSuggested',
                'nf.isUseful',
                'nf.isActive',
                'nf.isReviewed',
                'nf.isRelevant',
                'nf.isOutdated',
                'nf.isChecked',
                'nf.isValid',
                'nf.isBroken',
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
                return $this->mapBooleanInput($model['isActive']);
            })
            ->editColumn('news.isImported', function ($model) {
                return $this->mapBooleanInput($model['isImported']);
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
            ->rawColumns([
                'actions',
                'user.name',
                'news.isActive',
                'news.isImported',
                'bulkAction',
                'news.publishedAt'])
            ->make(true);
    }

    private function mapBooleanInput($input, $reverse = false)
    {
        $divClass = 'text-success';
        $divValue = $reverse ? 'No' : 'Yes';
        $iClass = 'fa-check';

        if ($input == 0) {
            $divClass = 'text-danger';
            $divValue = $reverse ? 'Yes' : 'No';
            $iClass = 'fa-times';
        }

        return vsprintf(
            '<div class="%s">%s <span class="badge badge-light"><i class="fas %s"></i></span></div>',
            [$divClass, $divValue, $iClass]
        );
    }
}
