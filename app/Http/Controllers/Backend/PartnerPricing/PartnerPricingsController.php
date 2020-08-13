<?php

namespace App\Http\Controllers\Backend\PartnerPricing;

use App\Models\PartnerPricing\PartnerPricing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\PartnerPricing\CreateResponse;
use App\Http\Responses\Backend\PartnerPricing\EditResponse;
use App\Repositories\Backend\PartnerPricing\PartnerPricingRepository;
use App\Http\Requests\Backend\PartnerPricing\ManagePartnerPricingRequest;
use App\Http\Requests\Backend\PartnerPricing\CreatePartnerPricingRequest;
use App\Http\Requests\Backend\PartnerPricing\StorePartnerPricingRequest;
use App\Http\Requests\Backend\PartnerPricing\EditPartnerPricingRequest;
use App\Http\Requests\Backend\PartnerPricing\UpdatePartnerPricingRequest;
use App\Http\Requests\Backend\PartnerPricing\DeletePartnerPricingRequest;

/**
 * PartnerPricingsController
 */
class PartnerPricingsController extends Controller
{
    /**
     * variable to store the repository object
     * @var PartnerPricingRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param PartnerPricingRepository $repository;
     */
    public function __construct(PartnerPricingRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\PartnerPricing\ManagePartnerPricingRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManagePartnerPricingRequest $request)
    {
        return new ViewResponse('backend.partnerpricings.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param  CreatePartnerPricingRequestNamespace  $request
     * @return \App\Http\Responses\Backend\PartnerPricing\CreateResponse
     */
    public function create(CreatePartnerPricingRequest $request)
    {
        return new CreateResponse('backend.partnerpricings.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePartnerPricingRequestNamespace  $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StorePartnerPricingRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('admin.partnerpricings.index'), ['flash_success' => trans('alerts.backend.partnerpricings.created')]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\PartnerPricing\PartnerPricing  $partnerpricing
     * @param  EditPartnerPricingRequestNamespace  $request
     * @return \App\Http\Responses\Backend\PartnerPricing\EditResponse
     */
    public function edit(PartnerPricing $partnerpricing, EditPartnerPricingRequest $request)
    {
        return new EditResponse($partnerpricing);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePartnerPricingRequestNamespace  $request
     * @param  App\Models\PartnerPricing\PartnerPricing  $partnerpricing
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(UpdatePartnerPricingRequest $request, PartnerPricing $partnerpricing)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Update the model using repository update method
        $this->repository->update( $partnerpricing, $input );
        //return with successfull message
        return new RedirectResponse(route('admin.partnerpricings.index'), ['flash_success' => trans('alerts.backend.partnerpricings.updated')]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  DeletePartnerPricingRequestNamespace  $request
     * @param  App\Models\PartnerPricing\PartnerPricing  $partnerpricing
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(PartnerPricing $partnerpricing, DeletePartnerPricingRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($partnerpricing);
        //returning with successfull message
        return new RedirectResponse(route('admin.partnerpricings.index'), ['flash_success' => trans('alerts.backend.partnerpricings.deleted')]);
    }
    
}
