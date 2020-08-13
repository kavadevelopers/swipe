<?php

namespace App\Http\Controllers\Backend\Partnerfaq;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\Partnerfaq\PartnerfaqRepository;
use App\Http\Requests\Backend\Partnerfaq\ManagePartnerfaqRequest;

/**
 * Class PartnerfaqsTableController.
 */
class PartnerfaqsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var PartnerfaqRepository
     */
    protected $partnerfaq;

    /**
     * contructor to initialize repository object
     * @param PartnerfaqRepository $partnerfaq;
     */
    public function __construct(PartnerfaqRepository $partnerfaq)
    {
        $this->partnerfaq = $partnerfaq;
    }

    /**
     * This method return the data of the model
     * @param ManagePartnerfaqRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManagePartnerfaqRequest $request)
    {
        return Datatables::of($this->partnerfaq->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($partnerfaq) {
                return Carbon::parse($partnerfaq->created_at)->toDateString();
            })
            ->addColumn('actions', function ($partnerfaq) {
                return $partnerfaq->action_buttons;
            })
            ->make(true);
    }
}
