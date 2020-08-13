<?php

namespace App\Http\Controllers\Backend\PromoCodes;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\PromoCodes\PromoCodeRepository;
use App\Http\Requests\Backend\PromoCodes\ManagePromoCodeRequest;
use App\Models\Access\User\User;

/**
 * Class PromoCodesTableController.
 */
class PromoCodesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var PromoCodeRepository
     */
    protected $promocode;

    /**
     * contructor to initialize repository object
     * @param PromoCodeRepository $promocode;
     */
    public function __construct(PromoCodeRepository $promocode)
    {
        $this->promocode = $promocode;
    }

    /**
     * This method return the data of the model
     * @param ManagePromoCodeRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManagePromoCodeRequest $request)
    {
        return Datatables::of($this->promocode->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($promocode) {
                return Carbon::parse($promocode->created_at)->toDateString();
            })
            ->addColumn('createdBy', function ($promocode) {
                $creator = User::find($promocode->created_by);
                return $creator->fullname();
            })
            ->addColumn('count_limit', function ($promocode) {
                return "0/$promocode->count_limit";
            })
            ->addColumn('time_limit', function ($promocode) {
                return Carbon::parse($promocode->start_date)->toDateString()." - ".Carbon::parse($promocode->end_date)->toDateString();
            })
            ->make(true);
    }
}
