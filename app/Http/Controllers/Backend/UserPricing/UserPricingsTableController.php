<?php

namespace App\Http\Controllers\Backend\UserPricing;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\UserPricing\UserPricingRepository;
use App\Http\Requests\Backend\UserPricing\ManageUserPricingRequest;

/**
 * Class UserPricingsTableController.
 */
class UserPricingsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var UserPricingRepository
     */
    protected $userpricing;

    /**
     * contructor to initialize repository object
     * @param UserPricingRepository $userpricing;
     */
    public function __construct(UserPricingRepository $userpricing)
    {
        $this->userpricing = $userpricing;
    }

    /**
     * This method return the data of the model
     * @param ManageUserPricingRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageUserPricingRequest $request)
    {
        return Datatables::of($this->userpricing->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($userpricing) {
                return Carbon::parse($userpricing->created_at)->toDateString();
            })
            ->addColumn('actions', function ($userpricing) {
                return $userpricing->action_buttons;
            })
            ->make(true);
    }
}
