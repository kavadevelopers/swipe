<?php

namespace App\Http\Controllers\Backend\Partnerfaq;

use App\Models\Partnerfaq\Partnerfaq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\Partnerfaq\CreateResponse;
use App\Http\Responses\Backend\Partnerfaq\EditResponse;
use App\Repositories\Backend\Partnerfaq\PartnerfaqRepository;
use App\Http\Requests\Backend\Partnerfaq\ManagePartnerfaqRequest;
use App\Http\Requests\Backend\Partnerfaq\CreatePartnerfaqRequest;
use App\Http\Requests\Backend\Partnerfaq\StorePartnerfaqRequest;
use App\Http\Requests\Backend\Partnerfaq\EditPartnerfaqRequest;
use App\Http\Requests\Backend\Partnerfaq\UpdatePartnerfaqRequest;
use App\Http\Requests\Backend\Partnerfaq\DeletePartnerfaqRequest;

/**
 * PartnerfaqsController
 */
class PartnerfaqsController extends Controller
{
    /**
     * variable to store the repository object
     * @var PartnerfaqRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param PartnerfaqRepository $repository;
     */
    public function __construct(PartnerfaqRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\Partnerfaq\ManagePartnerfaqRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManagePartnerfaqRequest $request)
    {
        return new ViewResponse('backend.partnerfaqs.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param  CreatePartnerfaqRequestNamespace  $request
     * @return \App\Http\Responses\Backend\Partnerfaq\CreateResponse
     */
    public function create(CreatePartnerfaqRequest $request)
    {
        return new CreateResponse('backend.partnerfaqs.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePartnerfaqRequestNamespace  $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StorePartnerfaqRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('admin.partnerfaqs.index'), ['flash_success' => trans('alerts.backend.partnerfaqs.created')]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\Partnerfaq\Partnerfaq  $partnerfaq
     * @param  EditPartnerfaqRequestNamespace  $request
     * @return \App\Http\Responses\Backend\Partnerfaq\EditResponse
     */
    public function edit(Partnerfaq $partnerfaq, EditPartnerfaqRequest $request)
    {
        return new EditResponse($partnerfaq);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePartnerfaqRequestNamespace  $request
     * @param  App\Models\Partnerfaq\Partnerfaq  $partnerfaq
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(UpdatePartnerfaqRequest $request, Partnerfaq $partnerfaq)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Update the model using repository update method
        $this->repository->update( $partnerfaq, $input );
        //return with successfull message
        return new RedirectResponse(route('admin.partnerfaqs.index'), ['flash_success' => trans('alerts.backend.partnerfaqs.updated')]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  DeletePartnerfaqRequestNamespace  $request
     * @param  App\Models\Partnerfaq\Partnerfaq  $partnerfaq
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Partnerfaq $partnerfaq, DeletePartnerfaqRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($partnerfaq);
        //returning with successfull message
        return new RedirectResponse(route('admin.partnerfaqs.index'), ['flash_success' => trans('alerts.backend.partnerfaqs.deleted')]);
    }

    public function show()
    {
        return abort(404);
    }
}
