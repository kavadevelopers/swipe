<?php

namespace App\Http\Controllers\Backend\UsersList;

use App\Models\UsersList\UserList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\UsersList\CreateResponse;
use App\Http\Responses\Backend\UsersList\EditResponse;
use App\Repositories\Backend\UsersList\UserListRepository;
use App\Http\Requests\Backend\UsersList\ManageUserListRequest;
use App\Http\Requests\Backend\UsersList\CreateUserListRequest;
use App\Http\Requests\Backend\UsersList\StoreUserListRequest;
use App\Http\Requests\Backend\UsersList\EditUserListRequest;
use App\Http\Requests\Backend\UsersList\UpdateUserListRequest;
use App\Http\Requests\Backend\UsersList\DeleteUserListRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Models\CarWashBooking\CarWashBooking;
use Carbon\Carbon;
use App\Models\Vehicle\VehicalType;
/**
 * UserListsController
 */
class UserListsController extends Controller
{
    /**
     * variable to store the repository object
     * @var UserListRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param UserListRepository $repository;
     */
    public function __construct(UserListRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\UsersList\ManageUserListRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageUserListRequest $request)
    {
        return new ViewResponse('backend.userlists.userlists');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param  CreateUserListRequestNamespace  $request
     * @return \App\Http\Responses\Backend\UsersList\CreateResponse
     */
    public function create(CreateUserListRequest $request)
    {
        return new CreateResponse('backend.userlists.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUserListRequestNamespace  $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StoreUserListRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Create the model using repository create method
        $this->repository->create($input);
        //return with successfull message
        return new RedirectResponse(route('admin.userlists.index'), ['flash_success' => trans('alerts.backend.userlists.created')]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\UsersList\UserList  $userlist
     * @param  EditUserListRequestNamespace  $request
     * @return \App\Http\Responses\Backend\UsersList\EditResponse
     */
    public function edit(UserList $userlist, EditUserListRequest $request)
    {
        return new EditResponse($userlist);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserListRequestNamespace  $request
     * @param  App\Models\UsersList\UserList  $userlist
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(UpdateUserListRequest $request, UserList $userlist)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Update the model using repository update method
        $this->repository->update( $userlist, $input );
        //return with successfull message
        return new RedirectResponse(route('admin.userlists.index'), ['flash_success' => trans('alerts.backend.userlists.updated')]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteUserListRequestNamespace  $request
     * @param  App\Models\UsersList\UserList  $userlist
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(UserList $userlist, DeleteUserListRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($userlist);
        //returning with successfull message
        return new RedirectResponse(route('admin.userlists.index'), ['flash_success' => trans('alerts.backend.userlists.deleted')]);
    }

    public function userActivities(UserList $userlist)
    {
        $viewData = [
            "user" => $userlist
        ];
        return new ViewResponse('backend.userlists.user-activities', $viewData);
    }

    public function userActivitiesDatatable(UserList $userlist)
    {
        $data = UserList::with(['bookinglist.washer', 'bookinglist.user'])->find($userlist->id);

        foreach ($data->bookinglist as $key => $value) {
            $vehicalData = VehicalType::find($value->vehicle_id);
            $data->bookinglist[$key]->vehical_name = ($vehicalData != null)?$vehicalData->vehical_name:"";
        }

        return Datatables::of($data->bookinglist)
                        ->addColumn('washername', function ($bookinglist) {
                            if (isset($bookinglist->washer)) {
                                return $bookinglist->washer->name;
                            }
                            return null;
                        })
                        ->addColumn('username', function ($bookinglist) {
                            if (isset($bookinglist->user)) {
                                return $bookinglist->user->name;
                            }
                            return null;
                        })
                        ->addColumn('bookingDate', function ($bookinglist) {
                            if (isset($bookinglist->date)) {
                                $createdAt = Carbon::parse($bookinglist->date);
                                $date = $createdAt->format('d-m-Y');
                                return $date;
                            }
                            return null;
                        })
                        ->addColumn('bookingTime', function ($bookinglist) {
                            if (isset($bookinglist->start_time)) {
                                $date = Carbon::parse($bookinglist->start_time)->timezone('Asia/Singapore')->format('H:i');
                                return $date;
                            }
                            return null;
                        })
                        ->addColumn('duration', function ($bookinglist) {
                            if (isset($bookinglist->start_time) && isset($bookinglist->end_time)) {
                                $startTime = Carbon::parse($bookinglist->start_time);
                                $endTime = Carbon::parse($bookinglist->end_time);
                                $totalDuration = $endTime->diffInSeconds($startTime);
                                return gmdate('H:i', $totalDuration);
                            }
                            return null;
                        })
                        ->make(true);
    }

    public function showPartnerList(ManageUserListRequest $request)
    {
        return new ViewResponse('backend.userlists.partnerlist');
    }

    public function getPartnerList(ManageUserListRequest $request)
    {
        return Datatables::of($this->repository->getForDataTable()->where('user_type', 'washer'))
                        ->escapeColumns(['id'])
                        ->addColumn('created_at', function ($userlist) {
                            return Carbon::parse($userlist->created_at)->toDateString();
                        })
                        ->make(true);
    }

    public function partnerActivities(UserList $partner)
    {
        $viewData = [
            "partner" => $partner
        ];
        return new ViewResponse('backend.userlists.partner-activities', $viewData);
    }

    public function cancelBooking($bookingId)
    {
        $result['code'] = 400;

        try {
            $booking = CarWashBooking::find($bookingId);
            $booking->status = 'Cancelled';
            $booking->cancel_by = auth()->user()->fullname();

            if ($booking->save()) {
                $result['code'] = 200;
                $result['message'] = 'Booking Successfully Cancelled';
            }
        } catch (\Throwable $th) {
            $result['message'] = $th->getMessage();
        }


        return response()->json($result, $result['code']);
    }
}
