<?php

namespace App\Http\Controllers\Backend\Revenue;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\Revenue\RevenueRepository;
use App\Http\Requests\Backend\Revenue\ManageRevenueRequest;

/**
 * Class RevenuesTableController.
 */
class RevenuesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var RevenueRepository
     */
    protected $revenue;

    /**
     * contructor to initialize repository object
     * @param RevenueRepository $revenue;
     */
    public function __construct(RevenueRepository $revenue)
    {
        $this->revenue = $revenue;
    }

    /**
     * This method return the data of the model
     * @param ManageRevenueRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageRevenueRequest $request)
    {
        return Datatables::of($this->revenue->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($revenue) {
                return Carbon::parse($revenue->created_at)->toDateString();
            })
            ->addColumn('actions', function ($revenue) {
                return $revenue->action_buttons;
            })
            ->make(true);
    }
}
