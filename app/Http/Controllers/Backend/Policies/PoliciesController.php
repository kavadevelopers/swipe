<?php

namespace App\Http\Controllers\Backend\Policies;

use App\Models\Policies\Policy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\Policies\CreateResponse;
use App\Http\Responses\Backend\Policies\EditResponse;
use App\Repositories\Backend\Policies\PolicyRepository;
use App\Http\Requests\Backend\Policies\ManagePolicyRequest;
use App\Http\Requests\Backend\Policies\CreatePolicyRequest;
use App\Http\Requests\Backend\Policies\StorePolicyRequest;
use App\Http\Requests\Backend\Policies\EditPolicyRequest;
use App\Http\Requests\Backend\Policies\UpdatePolicyRequest;
use App\Http\Requests\Backend\Policies\DeletePolicyRequest;

/**
 * PoliciesController
 */
class PoliciesController extends Controller
{
    /**
     * variable to store the repository object
     * @var PolicyRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param PolicyRepository $repository;
     */
    public function __construct(PolicyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\Policies\ManagePolicyRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManagePolicyRequest $request)
    {
        return new ViewResponse('backend.policies.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param  CreatePolicyRequestNamespace  $request
     * @return \App\Http\Responses\Backend\Policies\CreateResponse
     */
    public function create(CreatePolicyRequest $request)
    {
        return new CreateResponse('backend.policies.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePolicyRequestNamespace  $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StorePolicyRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('admin.policies.index'), ['flash_success' => trans('alerts.backend.policies.created')]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\Policies\Policy  $policy
     * @param  EditPolicyRequestNamespace  $request
     * @return \App\Http\Responses\Backend\Policies\EditResponse
     */
    public function edit(Policy $policy, EditPolicyRequest $request)
    {
        return new EditResponse($policy);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePolicyRequestNamespace  $request
     * @param  App\Models\Policies\Policy  $policy
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(UpdatePolicyRequest $request, Policy $policy)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Update the model using repository update method
        $this->repository->update( $policy, $input );

        //return with successfull message
        return new RedirectResponse(route('admin.policies.show', $policy->id), ['flash_success' => trans('alerts.backend.policies.updated')]);

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  DeletePolicyRequestNamespace  $request
     * @param  App\Models\Policies\Policy  $policy
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Policy $policy, DeletePolicyRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($policy);
        //returning with successfull message
        return new RedirectResponse(route('admin.policies.index'), ['flash_success' => trans('alerts.backend.policies.deleted')]);
    }

    public function show(Policy $policy)
    {
        $viewData = [
            'policy' => $policy
        ];
        return new ViewResponse('backend.policies.show', $viewData);
    }

}
