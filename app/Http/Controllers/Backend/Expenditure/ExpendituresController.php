<?php

namespace App\Http\Controllers\Backend\Expenditure;

use App\Models\Expenditure\Expenditure;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\Expenditure\CreateResponse;
use App\Http\Responses\Backend\Expenditure\EditResponse;
use App\Repositories\Backend\Expenditure\ExpenditureRepository;
use App\Http\Requests\Backend\Expenditure\ManageExpenditureRequest;
use App\Http\Requests\Backend\Expenditure\CreateExpenditureRequest;
use App\Http\Requests\Backend\Expenditure\StoreExpenditureRequest;
use App\Http\Requests\Backend\Expenditure\EditExpenditureRequest;
use App\Http\Requests\Backend\Expenditure\UpdateExpenditureRequest;
use App\Http\Requests\Backend\Expenditure\DeleteExpenditureRequest;

/**
 * ExpendituresController
 */
class ExpendituresController extends Controller
{
    /**
     * variable to store the repository object
     * @var ExpenditureRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param ExpenditureRepository $repository;
     */
    public function __construct(ExpenditureRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\Expenditure\ManageExpenditureRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageExpenditureRequest $request)
    {
        return new ViewResponse('backend.expenditures.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param  CreateExpenditureRequestNamespace  $request
     * @return \App\Http\Responses\Backend\Expenditure\CreateResponse
     */
    public function create(CreateExpenditureRequest $request)
    {
        return new CreateResponse('backend.expenditures.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreExpenditureRequestNamespace  $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StoreExpenditureRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('admin.expenditures.index'), ['flash_success' => trans('alerts.backend.expenditures.created')]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\Expenditure\Expenditure  $expenditure
     * @param  EditExpenditureRequestNamespace  $request
     * @return \App\Http\Responses\Backend\Expenditure\EditResponse
     */
    public function edit(Expenditure $expenditure, EditExpenditureRequest $request)
    {
        return new EditResponse($expenditure);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateExpenditureRequestNamespace  $request
     * @param  App\Models\Expenditure\Expenditure  $expenditure
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(UpdateExpenditureRequest $request, Expenditure $expenditure)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Update the model using repository update method
        $this->repository->update( $expenditure, $input );
        //return with successfull message
        return new RedirectResponse(route('admin.expenditures.index'), ['flash_success' => trans('alerts.backend.expenditures.updated')]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteExpenditureRequestNamespace  $request
     * @param  App\Models\Expenditure\Expenditure  $expenditure
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Expenditure $expenditure, DeleteExpenditureRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($expenditure);
        //returning with successfull message
        return new RedirectResponse(route('admin.expenditures.index'), ['flash_success' => trans('alerts.backend.expenditures.deleted')]);
    }
    
    public function userReward(Request $request)
    {
        return view('backend.expenditures.userrewards');
    }
    
    public function partnerRedemptions(Request $request)
    {
        return view('backend.expenditures.partnerredemptions');
    }
}
