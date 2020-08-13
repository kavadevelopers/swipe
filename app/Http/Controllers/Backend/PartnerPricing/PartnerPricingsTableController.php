<?php

namespace App\Http\Controllers\Backend\PartnerPricing;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\PartnerPricing\PartnerPricingRepository;
use App\Http\Requests\Backend\PartnerPricing\ManagePartnerPricingRequest;

/**
 * Class PartnerPricingsTableController.
 */
class PartnerPricingsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var PartnerPricingRepository
     */
    protected $partnerpricing;

    /**
     * contructor to initialize repository object
     * @param PartnerPricingRepository $partnerpricing;
     */
    public function __construct(PartnerPricingRepository $partnerpricing)
    {
        $this->partnerpricing = $partnerpricing;
    }

    /**
     * This method return the data of the model
     * @param ManagePartnerPricingRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManagePartnerPricingRequest $request)
    {
        return Datatables::of($this->partnerpricing->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($partnerpricing) {
                return Carbon::parse($partnerpricing->created_at)->toDateString();
            })
            ->addColumn('actions', function ($partnerpricing) {
                return $partnerpricing->action_buttons;
            })
            ->make(true);
    }
}
