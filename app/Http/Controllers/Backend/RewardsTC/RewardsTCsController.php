<?php

namespace App\Http\Controllers\Backend\RewardsTC;

use App\Models\RewardsTC\RewardsTC;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\RewardsTC\CreateResponse;
use App\Http\Responses\Backend\RewardsTC\EditResponse;
use App\Repositories\Backend\RewardsTC\RewardsTCRepository;
use App\Http\Requests\Backend\RewardsTC\ManageRewardsTCRequest;
use App\Http\Requests\Backend\RewardsTC\CreateRewardsTCRequest;
use App\Http\Requests\Backend\RewardsTC\StoreRewardsTCRequest;
use App\Http\Requests\Backend\RewardsTC\EditRewardsTCRequest;
use App\Http\Requests\Backend\RewardsTC\UpdateRewardsTCRequest;
use App\Http\Requests\Backend\RewardsTC\DeleteRewardsTCRequest;

/**
 * RewardsTCsController
 */
class RewardsTCsController extends Controller
{
    /**
     * variable to store the repository object
     * @var RewardsTCRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param RewardsTCRepository $repository;
     */
    public function __construct(RewardsTCRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\RewardsTC\ManageRewardsTCRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageRewardsTCRequest $request)
    {
        return new ViewResponse('backend.rewardstcs.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param  CreateRewardsTCRequestNamespace  $request
     * @return \App\Http\Responses\Backend\RewardsTC\CreateResponse
     */
    public function create(CreateRewardsTCRequest $request)
    {
        return new CreateResponse('backend.rewardstcs.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRewardsTCRequestNamespace  $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StoreRewardsTCRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('admin.rewardstcs.index'), ['flash_success' => trans('alerts.backend.rewardstcs.created')]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\RewardsTC\RewardsTC  $rewardstc
     * @param  EditRewardsTCRequestNamespace  $request
     * @return \App\Http\Responses\Backend\RewardsTC\EditResponse
     */
    public function edit(RewardsTC $rewardstc, EditRewardsTCRequest $request)
    {
        return new EditResponse($rewardstc);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRewardsTCRequestNamespace  $request
     * @param  App\Models\RewardsTC\RewardsTC  $rewardstc
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(UpdateRewardsTCRequest $request, RewardsTC $rewardstc)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Update the model using repository update method
        $this->repository->update( $rewardstc, $input );
        //return with successfull message
        return new RedirectResponse(route('admin.rewardstcs.index'), ['flash_success' => trans('alerts.backend.rewardstcs.updated')]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRewardsTCRequestNamespace  $request
     * @param  App\Models\RewardsTC\RewardsTC  $rewardstc
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(RewardsTC $rewardstc, DeleteRewardsTCRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($rewardstc);
        //returning with successfull message
        return new RedirectResponse(route('admin.rewardstcs.index'), ['flash_success' => trans('alerts.backend.rewardstcs.deleted')]);
    }

    public function show()
    {
        return abort(404);
    }
}
