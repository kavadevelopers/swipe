<?php

namespace App\Http\Controllers\Backend\UserPricing;

use App\Models\UserPricing\UserPricing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\UserPricing\CreateResponse;
use App\Http\Responses\Backend\UserPricing\EditResponse;
use App\Repositories\Backend\UserPricing\UserPricingRepository;
use App\Http\Requests\Backend\UserPricing\ManageUserPricingRequest;
use App\Http\Requests\Backend\UserPricing\CreateUserPricingRequest;
use App\Http\Requests\Backend\UserPricing\StoreUserPricingRequest;
use App\Http\Requests\Backend\UserPricing\EditUserPricingRequest;
use App\Http\Requests\Backend\UserPricing\UpdateUserPricingRequest;
use App\Http\Requests\Backend\UserPricing\DeleteUserPricingRequest;

/**
 * UserPricingsController
 */
class UserPricingsController extends Controller
{
    /**
     * variable to store the repository object
     * @var UserPricingRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param UserPricingRepository $repository;
     */
    public function __construct(UserPricingRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\UserPricing\ManageUserPricingRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageUserPricingRequest $request)
    {
        return new ViewResponse('backend.userpricings.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param  CreateUserPricingRequestNamespace  $request
     * @return \App\Http\Responses\Backend\UserPricing\CreateResponse
     */
    public function create(CreateUserPricingRequest $request)
    {
        return new CreateResponse('backend.userpricings.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUserPricingRequestNamespace  $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StoreUserPricingRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('admin.userpricings.index'), ['flash_success' => trans('alerts.backend.userpricings.created')]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\UserPricing\UserPricing  $userpricing
     * @param  EditUserPricingRequestNamespace  $request
     * @return \App\Http\Responses\Backend\UserPricing\EditResponse
     */
    public function edit(UserPricing $userpricing, EditUserPricingRequest $request)
    {
        return new EditResponse($userpricing);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserPricingRequestNamespace  $request
     * @param  App\Models\UserPricing\UserPricing  $userpricing
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(UpdateUserPricingRequest $request, UserPricing $userpricing)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Update the model using repository update method
        $this->repository->update( $userpricing, $input );
        //return with successfull message
        return new RedirectResponse(route('admin.userpricings.index'), ['flash_success' => trans('alerts.backend.userpricings.updated')]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteUserPricingRequestNamespace  $request
     * @param  App\Models\UserPricing\UserPricing  $userpricing
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(UserPricing $userpricing, DeleteUserPricingRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($userpricing);
        //returning with successfull message
        return new RedirectResponse(route('admin.userpricings.index'), ['flash_success' => trans('alerts.backend.userpricings.deleted')]);
    }
    
}
