<?php

namespace App\Http\Controllers\Backend\Policies;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\Policies\PolicyRepository;
use App\Http\Requests\Backend\Policies\ManagePolicyRequest;

/**
 * Class PoliciesTableController.
 */
class PoliciesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var PolicyRepository
     */
    protected $policy;

    /**
     * contructor to initialize repository object
     * @param PolicyRepository $policy;
     */
    public function __construct(PolicyRepository $policy)
    {
        $this->policy = $policy;
    }

    /**
     * This method return the data of the model
     * @param ManagePolicyRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManagePolicyRequest $request)
    {
        return Datatables::of($this->policy->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($policy) {
                return Carbon::parse($policy->created_at)->toDateString();
            })
            ->addColumn('actions', function ($policy) {
                return $policy->action_buttons;
            })
            ->make(true);
    }
}
