<?php

namespace App\Http\Controllers\Backend\PromoCodes;

use App\Models\PromoCodes\PromoCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\PromoCodes\CreateResponse;
use App\Http\Responses\Backend\PromoCodes\EditResponse;
use App\Repositories\Backend\PromoCodes\PromoCodeRepository;
use App\Http\Requests\Backend\PromoCodes\ManagePromoCodeRequest;
use App\Http\Requests\Backend\PromoCodes\CreatePromoCodeRequest;
use App\Http\Requests\Backend\PromoCodes\StorePromoCodeRequest;
use App\Http\Requests\Backend\PromoCodes\EditPromoCodeRequest;
use App\Http\Requests\Backend\PromoCodes\UpdatePromoCodeRequest;
use App\Http\Requests\Backend\PromoCodes\DeletePromoCodeRequest;

/**
 * PromoCodesController
 */
class PromoCodesController extends Controller
{
    /**
     * variable to store the repository object
     * @var PromoCodeRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param PromoCodeRepository $repository;
     */
    public function __construct(PromoCodeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\PromoCodes\ManagePromoCodeRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManagePromoCodeRequest $request)
    {
        return new ViewResponse('backend.promocodes.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param  CreatePromoCodeRequestNamespace  $request
     * @return \App\Http\Responses\Backend\PromoCodes\CreateResponse
     */
    public function create(CreatePromoCodeRequest $request)
    {
        return new CreateResponse('backend.promocodes.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePromoCodeRequestNamespace  $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StorePromoCodeRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        $input['created_by'] = auth()->user()->id;

        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('admin.promocodes.index'), ['flash_success' => trans('alerts.backend.promocodes.created')]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\PromoCodes\PromoCode  $promocode
     * @param  EditPromoCodeRequestNamespace  $request
     * @return \App\Http\Responses\Backend\PromoCodes\EditResponse
     */
    public function edit(PromoCode $promocode, EditPromoCodeRequest $request)
    {
        return new EditResponse($promocode);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePromoCodeRequestNamespace  $request
     * @param  App\Models\PromoCodes\PromoCode  $promocode
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(UpdatePromoCodeRequest $request, PromoCode $promocode)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Update the model using repository update method
        $this->repository->update( $promocode, $input );
        //return with successfull message
        return new RedirectResponse(route('admin.promocodes.index'), ['flash_success' => trans('alerts.backend.promocodes.updated')]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  DeletePromoCodeRequestNamespace  $request
     * @param  App\Models\PromoCodes\PromoCode  $promocode
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(PromoCode $promocode, DeletePromoCodeRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($promocode);
        //returning with successfull message
        return new RedirectResponse(route('admin.promocodes.index'), ['flash_success' => trans('alerts.backend.promocodes.deleted')]);
    }

    public function updateStatus(Request $request)
    {
        $result = [
            'code' => 400
        ];

        try {
            $promoId = $request->id;
            $status = json_decode($request->status);

            $promoCode = PromoCode::select('*');

            if ($promoId != "all") {
                $promoCode = $promoCode->where('id', $promoId);
            }

            if($promoId == "all" && $status){
                $status = false;
            }else{
                $status = true;
            }
            $isUpdated = $promoCode->update(['status' => $status]);

            if ($isUpdated) {
                $result['code'] = 200;
                $result['message'] = "Promocode successfully updated";
            } else {
                $result['message'] = "Something went wrong, Please try again later.";
            }

        } catch (\Throwable $th) {
            $result['message'] = $th->getMessage();
        }

        return response()->json($result, $result['code']);
    }

}
