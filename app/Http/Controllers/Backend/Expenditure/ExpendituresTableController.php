<?php

namespace App\Http\Controllers\Backend\Expenditure;

use Carbon\Carbon;
use App\Models\Booking;
use App\Models\PartnerRedemption\PartnerRedemption;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\Expenditure\ExpenditureRepository;
use App\Http\Requests\Backend\Expenditure\ManageExpenditureRequest;
use DB;
/**
 * Class ExpendituresTableController.
 */
class ExpendituresTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var ExpenditureRepository
     */
    protected $expenditure;

    /**
     * contructor to initialize repository object
     * @param ExpenditureRepository $expenditure;
     */
    public function __construct(ExpenditureRepository $expenditure)
    {
        $this->expenditure = $expenditure;
    }

    /**
     * This method return the data of the model
     * @param ManageExpenditureRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageExpenditureRequest $request)
    {
        $promoData = Booking::select('*',DB::raw('count(*) as booking_promp_count'))
                                ->where(['status' => 'Completed', 'payment_status'=> 'paid', 'isPromo' => '1' ])
                                ->where('booking_promp', '!=', null)
                                ->groupby('booking_promp')
                                ->get();
        
        return Datatables::of($promoData)
            ->escapeColumns(['id'])
            ->make(true);
    }
    
    public function getUserReward(ManageExpenditureRequest $request)
    {
        $userReward = DB::table('car_wash_bookings')->select('*',DB::raw('count(booking_promp) as booking_promp_count'))
                                ->where(['status' => 'Completed', 'payment_status'=> 'paid', 'isPromo' => '1'])
                                ->where('booking_promp', '!=', null)
                                ->where(function ($query) {
                                    $query->where('booking_promp', '=', '$7 off')
                                          ->orWhere('booking_promp', '=', '$3 off');
                                })
                                ->get();
        
        return Datatables::of($userReward)
            ->escapeColumns(['id'])
            ->make(true);
    }

    public function partnerRedemptions (Type $var = null)
    {
        $partnerRedemption =  PartnerRedemption::select('*')->where('status', '=', 'pending' )->where('type','redemption')->get();

        return Datatables::of($partnerRedemption)
            ->escapeColumns(['id'])
            ->make(true);
    }
}
