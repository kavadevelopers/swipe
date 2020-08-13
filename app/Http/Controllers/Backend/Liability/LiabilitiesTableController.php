<?php

namespace App\Http\Controllers\Backend\Liability;

use Carbon\Carbon;
use App\Models\Booking;
use App\Models\UsersList\UserList;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\Liability\LiabilityRepository;
use App\Http\Requests\Backend\Liability\ManageLiabilityRequest;
use DB;
/**
 * Class LiabilitiesTableController.
 */
class LiabilitiesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var LiabilityRepository
     */
    protected $liability;

    /**
     * contructor to initialize repository object
     * @param LiabilityRepository $liability;
     */
    public function __construct(LiabilityRepository $liability)
    {
        $this->liability = $liability;
    }

    /**
     * This method return the data of the model
     * @param ManageLiabilityRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageLiabilityRequest $request)
    {
        $LiabilityData = Booking::select('*')->where(['status' => 'Completed', 'payment_status'=> 'paid'])->where('accepted_by', '!=', 0)->groupby('accepted_by')->get();
        
        $washerData = UserList::whereIn('id',$LiabilityData->pluck('accepted_by'))->get();
        
        foreach($washerData as $key => $washer){
            $washerData[$key]->total_earn =  Booking::select('*')->where([ 'status' => 'Completed', 'payment_status'=> 'paid', 'user_id' => $washer->id ])->where('accepted_by', '!=', 0)->groupby('accepted_by')->sum('fare');
        }
        
        
        return Datatables::of($washerData)
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($liability) {
                return Carbon::parse($liability->created_at)->toDateString();
            })
            ->make(true);
    }
}
