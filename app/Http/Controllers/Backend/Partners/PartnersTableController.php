<?php

namespace App\Http\Controllers\Backend\Partners;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\Partners\PartnerRepository;
use App\Http\Requests\Backend\Partners\ManagePartnerRequest;

/**
 * Class PartnersTableController.
 */
class PartnersTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var PartnerRepository
     */
    protected $partner;

    /**
     * contructor to initialize repository object
     * @param PartnerRepository $partner;
     */
    public function __construct(PartnerRepository $partner)
    {
        $this->partner = $partner;
    }

    /**
     * This method return the data of the model
     * @param ManagePartnerRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManagePartnerRequest $request)
    {
        return Datatables::of($this->partner->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($partner) {
                return Carbon::parse($partner->created_at)->toDateString();
            })
            ->addColumn('actions', function ($partner) {
                return $partner->action_buttons;
            })
            ->make(true);
    }

    public function pendingPartners()
    {
        return Datatables::of($this->partner->getForDataTablePending())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($partner) {
                return Carbon::parse($partner->created_at)->toDateString();
            })
            ->addColumn('actions', function ($partner) {
                return $partner->action_buttons;
            })
            ->make(true);
    }

    public function confirmPartners()
    {
        return Datatables::of($this->partner->getForDataTableConfirm())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($partner) {
                return Carbon::parse($partner->created_at)->toDateString();
            })
            ->addColumn('actions', function ($partner) {
                return $partner->action_buttons;
            })
            ->make(true);
    }

    public function historyPartners()
    {
        return Datatables::of($this->partner->getForDataTableHistory())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($partner) {
                return Carbon::parse($partner->created_at)->toDateString();
            })
            ->addColumn('actions', function ($partner) {
                return $partner->action_buttons;
            })
            ->make(true);
    }


}
