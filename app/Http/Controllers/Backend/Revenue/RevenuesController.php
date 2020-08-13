<?php

namespace App\Http\Controllers\Backend\Revenue;

use App\Models\Revenue\Revenue;
use App\Models\UsersList\UserList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\Revenue\CreateResponse;
use App\Http\Responses\Backend\Revenue\EditResponse;
use App\Repositories\Backend\Revenue\RevenueRepository;
use App\Http\Requests\Backend\Revenue\ManageRevenueRequest;
use App\Http\Requests\Backend\Revenue\CreateRevenueRequest;
use App\Http\Requests\Backend\Revenue\StoreRevenueRequest;
use App\Http\Requests\Backend\Revenue\EditRevenueRequest;
use App\Http\Requests\Backend\Revenue\UpdateRevenueRequest;
use App\Http\Requests\Backend\Revenue\DeleteRevenueRequest;
use App\Models\Booking;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

/**
 * RevenuesController
 */
class RevenuesController extends Controller
{
    /**
     * variable to store the repository object
     * @var RevenueRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param RevenueRepository $repository;
     */
    public function __construct(RevenueRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\Revenue\ManageRevenueRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageRevenueRequest $request)
    {
        return new ViewResponse('backend.revenues.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param  CreateRevenueRequestNamespace  $request
     * @return \App\Http\Responses\Backend\Revenue\CreateResponse
     */
    public function create(CreateRevenueRequest $request)
    {
        return new CreateResponse('backend.revenues.create');
    }

    public function show($id, Request $request)
    {
        $partener = Revenue::find($id);
        return view('backend.revenues.viewpartner')->with(['partener' => $partener]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRevenueRequestNamespace  $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StoreRevenueRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('admin.revenues.index'), ['flash_success' => trans('alerts.backend.revenues.created')]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\Revenue\Revenue  $revenue
     * @param  EditRevenueRequestNamespace  $request
     * @return \App\Http\Responses\Backend\Revenue\EditResponse
     */
    public function edit(Revenue $revenue, EditRevenueRequest $request)
    {
        return new EditResponse($revenue);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRevenueRequestNamespace  $request
     * @param  App\Models\Revenue\Revenue  $revenue
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(UpdateRevenueRequest $request, Revenue $revenue)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Update the model using repository update method
        $this->repository->update( $revenue, $input );
        //return with successfull message
        return new RedirectResponse(route('admin.revenues.index'), ['flash_success' => trans('alerts.backend.revenues.updated')]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRevenueRequestNamespace  $request
     * @param  App\Models\Revenue\Revenue  $revenue
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Revenue $revenue, DeleteRevenueRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($revenue);
        //returning with successfull message
        return new RedirectResponse(route('admin.revenues.index'), ['flash_success' => trans('alerts.backend.revenues.deleted')]);
    }

    public function userBooking()
    {
        $bookingAmount = Booking::where(['payment_status'=>'paid', 'status'=>'Completed'])->whereDate('date', Carbon::today()->format('Y-m-d'))->sum('fare');
        
        return view('backend.revenues.userbooking')->with([ 'bookingAmount' => $bookingAmount ]);
    }

    public function getBooking()
    {
        $booking = Booking::with('userDetail')->where('payment_status','paid')->where('status','Completed')->get();
        
        return Datatables::of($booking)
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($revenue) {
                return Carbon::parse($revenue->created_at)->toDateString();
            })
            ->addColumn('bookingDate', function ($booking) {
                if (isset($booking->date)) {
                    $createdAt = Carbon::parse($booking->date);
                    $date = $createdAt->format('d-m-Y');
                    return $date;
                }
                return null;
            })
            ->make(true);
    }

    public function viewBooking($id)
    {
        
        $bookingData = Booking::where('id',$id)->first();
        $userData = UserList::find($bookingData->user_id);
        $partnerData = UserList::find($bookingData->accepted_by);
        
        return view('backend.revenues.viewbooking')->with([
                            'bookingData'=>$bookingData,
                            'userData' => $userData,
                            'partnerData' => $partnerData
                            ]);
    }
}
