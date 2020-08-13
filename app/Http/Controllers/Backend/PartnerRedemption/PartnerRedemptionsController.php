<?php

namespace App\Http\Controllers\Backend\PartnerRedemption;

use App\Models\PartnerRedemption\PartnerRedemption;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\PartnerRedemption\CreateResponse;
use App\Http\Responses\Backend\PartnerRedemption\EditResponse;
use App\Repositories\Backend\PartnerRedemption\PartnerRedemptionRepository;
use App\Http\Requests\Backend\PartnerRedemption\ManagePartnerRedemptionRequest;
use App\Http\Requests\Backend\PartnerRedemption\CreatePartnerRedemptionRequest;
use App\Http\Requests\Backend\PartnerRedemption\StorePartnerRedemptionRequest;
use App\Http\Requests\Backend\PartnerRedemption\EditPartnerRedemptionRequest;
use App\Http\Requests\Backend\PartnerRedemption\UpdatePartnerRedemptionRequest;
use App\Http\Requests\Backend\PartnerRedemption\DeletePartnerRedemptionRequest;
use PDF;
/**
 * PartnerRedemptionsController
 */
class PartnerRedemptionsController extends Controller
{
    /**
     * variable to store the repository object
     * @var PartnerRedemptionRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param PartnerRedemptionRepository $repository;
     */
    public function __construct(PartnerRedemptionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\PartnerRedemption\ManagePartnerRedemptionRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManagePartnerRedemptionRequest $request)
    {
        return new ViewResponse('backend.partnerredemptions.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param  CreatePartnerRedemptionRequestNamespace  $request
     * @return \App\Http\Responses\Backend\PartnerRedemption\CreateResponse
     */
    public function create(CreatePartnerRedemptionRequest $request)
    {
        return new CreateResponse('backend.partnerredemptions.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePartnerRedemptionRequestNamespace  $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StorePartnerRedemptionRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('admin.partnerredemptions.index'), ['flash_success' => trans('alerts.backend.partnerredemptions.created')]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\PartnerRedemption\PartnerRedemption  $partnerredemption
     * @param  EditPartnerRedemptionRequestNamespace  $request
     * @return \App\Http\Responses\Backend\PartnerRedemption\EditResponse
     */
    public function edit(PartnerRedemption $partnerredemption, EditPartnerRedemptionRequest $request)
    {
        return new EditResponse($partnerredemption);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePartnerRedemptionRequestNamespace  $request
     * @param  App\Models\PartnerRedemption\PartnerRedemption  $partnerredemption
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(UpdatePartnerRedemptionRequest $request, PartnerRedemption $partnerredemption)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Update the model using repository update method
        $this->repository->update( $partnerredemption, $input );
        //return with successfull message
        return new RedirectResponse(route('admin.partnerredemptions.index'), ['flash_success' => trans('alerts.backend.partnerredemptions.updated')]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  DeletePartnerRedemptionRequestNamespace  $request
     * @param  App\Models\PartnerRedemption\PartnerRedemption  $partnerredemption
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(PartnerRedemption $partnerredemption, DeletePartnerRedemptionRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($partnerredemption);
        //returning with successfull message
        return new RedirectResponse(route('admin.partnerredemptions.index'), ['flash_success' => trans('alerts.backend.partnerredemptions.deleted')]);
    }
    
    public function generatePdf(Request $request)
    {
        $input = $request->all();
        $data = PartnerRedemption::whereIn('id',$input['idArr'])->get();
        // \Log::info("data for pd => ".json_encode($data));
        
        return response()->json(["code" => 200, "message" => 'success', "data" => $data], 200);
        // $pdf = PDF::loadView('pdf.redemption', $data);
        // return $pdf->download('Redemption.pdf');
    }
    
    public function processed(Request $request)
    {
        $input = $request->all();
        $data = PartnerRedemption::whereIn('id',$input['idArr'])->update(['status'=> 'process']);
        // \Log::info("data for pd => ".json_encode($data));
        
        return response()->json(["code" => 200, "message" => 'success', "data" => $data], 200);
        // $pdf = PDF::loadView('pdf.redemption', $data);
        // return $pdf->download('Redemption.pdf');
    }

    public function getHistory()
    {
        return view('backend.partnerredemptions.history');
    }
    
    public function onbordingIndex()
    {
        return view('backend.partnerredemptions.onbordingIndex');
    }
    
    public function getOnboardingHistory()
    {
        return view('backend.partnerredemptions.onboardinghistory');
    }
}
