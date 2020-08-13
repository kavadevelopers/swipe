<?php

namespace App\Http\Controllers\Backend\PartnerRedemption;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\PartnerRedemption\PartnerRedemptionRepository;
use App\Http\Requests\Backend\PartnerRedemption\ManagePartnerRedemptionRequest;

/**
 * Class PartnerRedemptionsTableController.
 */
class PartnerRedemptionsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var PartnerRedemptionRepository
     */
    protected $partnerredemption;

    /**
     * contructor to initialize repository object
     * @param PartnerRedemptionRepository $partnerredemption;
     */
    public function __construct(PartnerRedemptionRepository $partnerredemption)
    {
        $this->partnerredemption = $partnerredemption;
    }

    /**
     * This method return the data of the model
     * @param ManagePartnerRedemptionRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManagePartnerRedemptionRequest $request)
    {
        return Datatables::of($this->partnerredemption->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($partnerredemption) {
                return Carbon::parse($partnerredemption->created_at)->toDateString();
            })
            ->addColumn('actions', function ($partnerredemption) {
                return $partnerredemption->action_buttons;
            })
            ->make(true);
    }

    public function getHistory(ManagePartnerRedemptionRequest $request)
    {
        
        return Datatables::of($this->partnerredemption->getHistoryForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($partnerredemption) {
                return Carbon::parse($partnerredemption->created_at)->toDateString();
            })
            ->addColumn('actions', function ($partnerredemption) {
                return $partnerredemption->action_buttons;
            })
            ->make(true);
    }
    
    public function getOnboarding(ManagePartnerRedemptionRequest $request)
    {
        return Datatables::of($this->partnerredemption->getOnboardingForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($partnerredemption) {
                return Carbon::parse($partnerredemption->created_at)->toDateString();
            })
            ->addColumn('actions', function ($partnerredemption) {
                return $partnerredemption->action_buttons;
            })
            ->make(true);
    }

    public function onboardGetHistory(ManagePartnerRedemptionRequest $request)
    {
        
        return Datatables::of($this->partnerredemption->getOnboardingHistoryForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($partnerredemption) {
                return Carbon::parse($partnerredemption->created_at)->toDateString();
            })
            ->addColumn('actions', function ($partnerredemption) {
                return $partnerredemption->action_buttons;
            })
            ->make(true);
    }
}
