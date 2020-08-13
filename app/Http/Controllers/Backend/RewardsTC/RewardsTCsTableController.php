<?php

namespace App\Http\Controllers\Backend\RewardsTC;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\RewardsTC\RewardsTCRepository;
use App\Http\Requests\Backend\RewardsTC\ManageRewardsTCRequest;

/**
 * Class RewardsTCsTableController.
 */
class RewardsTCsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var RewardsTCRepository
     */
    protected $rewardstc;

    /**
     * contructor to initialize repository object
     * @param RewardsTCRepository $rewardstc;
     */
    public function __construct(RewardsTCRepository $rewardstc)
    {
        $this->rewardstc = $rewardstc;
    }

    /**
     * This method return the data of the model
     * @param ManageRewardsTCRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageRewardsTCRequest $request)
    {
        return Datatables::of($this->rewardstc->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($rewardstc) {
                return Carbon::parse($rewardstc->created_at)->toDateString();
            })
            ->addColumn('actions', function ($rewardstc) {
                return $rewardstc->action_buttons;
            })
            ->make(true);
    }
}
