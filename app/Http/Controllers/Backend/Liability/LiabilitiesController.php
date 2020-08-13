<?php

namespace App\Http\Controllers\Backend\Liability;

use App\Models\Liability\Liability;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\Liability\CreateResponse;
use App\Http\Responses\Backend\Liability\EditResponse;
use App\Repositories\Backend\Liability\LiabilityRepository;
use App\Http\Requests\Backend\Liability\ManageLiabilityRequest;
use App\Http\Requests\Backend\Liability\CreateLiabilityRequest;
use App\Http\Requests\Backend\Liability\StoreLiabilityRequest;
use App\Http\Requests\Backend\Liability\EditLiabilityRequest;
use App\Http\Requests\Backend\Liability\UpdateLiabilityRequest;
use App\Http\Requests\Backend\Liability\DeleteLiabilityRequest;
use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Partners\PartnersBankdetails;
use App\Models\UsersList\UserList;
/**
 * LiabilitiesController
 */
class LiabilitiesController extends Controller
{
    /**
     * variable to store the repository object
     * @var LiabilityRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param LiabilityRepository $repository;
     */
    public function __construct(LiabilityRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\Liability\ManageLiabilityRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageLiabilityRequest $request)
    {
        return new ViewResponse('backend.liabilities.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param  CreateLiabilityRequestNamespace  $request
     * @return \App\Http\Responses\Backend\Liability\CreateResponse
     */
    public function create(CreateLiabilityRequest $request)
    {
        return new CreateResponse('backend.liabilities.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreLiabilityRequestNamespace  $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StoreLiabilityRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('admin.liabilities.index'), ['flash_success' => trans('alerts.backend.liabilities.created')]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\Liability\Liability  $liability
     * @param  EditLiabilityRequestNamespace  $request
     * @return \App\Http\Responses\Backend\Liability\EditResponse
     */
    public function edit(Liability $liability, EditLiabilityRequest $request)
    {
        return new EditResponse($liability);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateLiabilityRequestNamespace  $request
     * @param  App\Models\Liability\Liability  $liability
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(UpdateLiabilityRequest $request, Liability $liability)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Update the model using repository update method
        $this->repository->update( $liability, $input );
        //return with successfull message
        return new RedirectResponse(route('admin.liabilities.index'), ['flash_success' => trans('alerts.backend.liabilities.updated')]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteLiabilityRequestNamespace  $request
     * @param  App\Models\Liability\Liability  $liability
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Liability $liability, DeleteLiabilityRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($liability);
        //returning with successfull message
        return new RedirectResponse(route('admin.liabilities.index'), ['flash_success' => trans('alerts.backend.liabilities.deleted')]);
    }
    
    public function getBackDetail(Request $request)
    {
        $startDate = Carbon::parse($request->startDate)->format('Y-m-d');
        $endDate = Carbon::parse($request->endDate)->format('Y-m-d');

        $LiabilityData = Booking::select('*')->whereBetween('date',[$startDate, $endDate])->where(['status' => 'Completed', 'payment_status'=> 'paid'])->where('accepted_by', '!=', 0)->get();
        
        $washerData = UserList::whereIn('id',$LiabilityData->pluck('accepted_by'))->get();
        
        foreach($washerData as $key => $washer){
                $washerData[$key]->total_earn =  Booking::select('*')->where([ 'status' => 'Completed', 'payment_status'=> 'paid', 'user_id' => $washer->id ])->where('accepted_by', '!=', 0)->groupby('accepted_by')->sum('fare');
                $washerData[$key]->bank_detail = PartnersBankdetails::where('user_id',$washer->id)->first();
        }
        
        return response()->json(["code" => 200, "message" => 'success', "data" => $washerData], 200);
    }
}
