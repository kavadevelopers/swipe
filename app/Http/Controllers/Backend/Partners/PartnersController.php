<?php

namespace App\Http\Controllers\Backend\Partners;

use App\Models\Partners\Partner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\Partners\CreateResponse;
use App\Http\Responses\Backend\Partners\EditResponse;
use App\Repositories\Backend\Partners\PartnerRepository;
use App\Http\Requests\Backend\Partners\ManagePartnerRequest;
use App\Http\Requests\Backend\Partners\CreatePartnerRequest;
use App\Http\Requests\Backend\Partners\StorePartnerRequest;
use App\Http\Requests\Backend\Partners\EditPartnerRequest;
use App\Http\Requests\Backend\Partners\UpdatePartnerRequest;
use App\Http\Requests\Backend\Partners\DeletePartnerRequest;
use Illuminate\Support\Facades\Auth;
use Mail;
use Stripe;
use App\JoinFee;
use App\logistics;
use Illuminate\Support\Facades\DB;


/**
 * PartnersController
 */
class PartnersController extends Controller
{
    /**
     * variable to store the repository object
     * @var PartnerRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param PartnerRepository $repository;
     */
    public function __construct(PartnerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\Partners\ManagePartnerRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManagePartnerRequest $request)
    {
        return new ViewResponse('backend.partners.index');
    }

    public function pendingPartners()
    {
        return view('backend.partners.pending');
    }

    public function confirmPartners()
    {
        return view('backend.partners.confirm');
    }

    public function historyPartners()
    {
        return view('backend.partners.history');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  CreatePartnerRequestNamespace  $request
     * @return \App\Http\Responses\Backend\Partners\CreateResponse
     */
    public function create(CreatePartnerRequest $request)
    {
        return new CreateResponse('backend.partners.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePartnerRequestNamespace  $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StorePartnerRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('admin.partners.index'), ['flash_success' => trans('alerts.backend.partners.created')]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\Partners\Partner  $partner
     * @param  EditPartnerRequestNamespace  $request
     * @return \App\Http\Responses\Backend\Partners\EditResponse
     */
    public function edit(Partner $partner, EditPartnerRequest $request)
    {
        return new EditResponse($partner);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePartnerRequestNamespace  $request
     * @param  App\Models\Partners\Partner  $partner
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(UpdatePartnerRequest $request, Partner $partner)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Update the model using repository update method
        $this->repository->update( $partner, $input );
        //return with successfull message
        return new RedirectResponse(route('admin.partners.index'), ['flash_success' => trans('alerts.backend.partners.updated')]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  DeletePartnerRequestNamespace  $request
     * @param  App\Models\Partners\Partner  $partner
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Partner $partner, DeletePartnerRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($partner);
        //returning with successfull message
        return new RedirectResponse(route('admin.partners.index'), ['flash_success' => trans('alerts.backend.partners.deleted')]);
    }

    public function updateStatus(Request $request){
        $input = $request->all();
        $status = 0;
        $admin = Auth::user();

        
        if($input['status'] == 'Approve'){
            

            $status = 1;
            try {
                //code...
                $profile = DB::table('profiles')->where('user_id', $input['id'])->first();
                $payIntent = Stripe::paymentIntents()->
                create([
                    'amount' => 20,
                    'currency' => 'INR',
                    'description' => 'test description',
                    'customer' => $profile->customer_key,
                ]);
                $joinFee = [
                    'user_id' => $input['id'],
                    'payment_intent' => $payIntent['id'],
                    'amount' => '20',
                    'currency' => 'INR',
                    'status' => 'pending',
                ];
                JoinFee::create($joinFee);
                $logistics = [
                    'date_time' => now(),
                    'name' => $partner->name,
                    'address' => '',
                    'status' => 'pending',
                    'type' => 'on_bording',
                ];
                logistics::create($logistics);
                $updatePartner = $partner->update(['verification_status' => $status, 'admin_id' => $admin->id, 'activation_code'=> uniqid()]);
               // DB::table('users')->where('id',$input['id'])->update(['verification_status','1']);
                $partner = Partner::where('id',$input['id'])->first();
                $to_name = $partner->name;
                $to_email = $partner->email;
                Mail::send("vendor.notifications.paymentLink", ['partner' => $partner], function($message) use ($to_name, $to_email) {
                    $message->to($to_email, $to_name)
                    ->subject("Partener Approved");
                    $message->from("swipeadm2020@gmail.com","Approve Partner");
                });
            } catch (\Throwable $th) {
                
               return response()->json(["code" => 400, "message" => $th], 400);
            }
        }else{
            $status = 0;
            $updatePartner = Partner::where('id',$input['id'])->update(['status' => $status, 'user_type' => "user"]);
        }

        return response()->json(["code" => 200, "message" => 'success'], 200);
    }

    // public function show()
    // {
    //     return abort(404);
    // }

    public function onboardPay($uid)
    {
        $partner = Partner::where('activation_code',$uid)->first();
        $joinFee = JoinFee::where('user_id',$partner->id)->first();
        $paymentIntent = Stripe::paymentIntents()->find($joinFee->payment_intent);
        return view('frontend.onboard_payment')->with([
            'partner' => $partner,
            'joinFee' => $joinFee,
            'paymentIntent' => $paymentIntent['client_secret']
        ]);;
    }
}
