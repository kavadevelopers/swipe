<?php

namespace App\Http\Controllers\Backend\LoudHailer;

use App\Models\LoudHailer\LoudHailer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\LoudHailer\CreateResponse;
use App\Http\Responses\Backend\LoudHailer\EditResponse;
use App\Repositories\Backend\LoudHailer\LoudHailerRepository;
use App\Http\Requests\Backend\LoudHailer\ManageLoudHailerRequest;
use App\Http\Requests\Backend\LoudHailer\CreateLoudHailerRequest;
use App\Http\Requests\Backend\LoudHailer\StoreLoudHailerRequest;
use App\Http\Requests\Backend\LoudHailer\EditLoudHailerRequest;
use App\Http\Requests\Backend\LoudHailer\UpdateLoudHailerRequest;
use App\Http\Requests\Backend\LoudHailer\DeleteLoudHailerRequest;
use App\Models\Partners\Partner;
use App\Http\Utilities\PushNotification;
use App\Models\PushNotification\PushNotification as PushNotificationModel;
use App\Mail\SendMailFromAdmin;
use Illuminate\Support\Facades\Mail;

/**
 * LoudHailersController
 */
class LoudHailersController extends Controller
{
    /**
     * variable to store the repository object
     * @var LoudHailerRepository
     */
    protected $repository;

    /**
     * @var \App\Http\Utilities\PushNotification
     */
    protected $notification;

    /**
     * contructor to initialize repository object
     * @param LoudHailerRepository $repository;
     */
    public function __construct(LoudHailerRepository $repository, PushNotification $notification)
    {
        $this->repository = $repository;
        $this->notification = $notification;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\LoudHailer\ManageLoudHailerRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageLoudHailerRequest $request)
    {
        return new ViewResponse('backend.loudhailers.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param  CreateLoudHailerRequestNamespace  $request
     * @return \App\Http\Responses\Backend\LoudHailer\CreateResponse
     */
    public function create(CreateLoudHailerRequest $request)
    {
        $partnerTypes = Partner::groupBy('user_type')->pluck('user_type', 'user_type');

        $viewData = [
            "partnerTypes" => $partnerTypes
        ];
        return view('backend.loudhailers.create', $viewData);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreLoudHailerRequestNamespace  $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StoreLoudHailerRequest $request)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        $input['send_by'] = auth()->user()->id;

        $users = Partner::where('user_type', $input['send_to'])->pluck('id');

        $androidTokens = PushNotificationModel::whereIn('user_id',$users)->where('os','!=','ios')->pluck('notification_token');
        $iosTokens = PushNotificationModel::whereIn('user_id',$users)->where('os','ios')->pluck('notification_token');

        if (count($androidTokens)) {
            $notificationData = [
                'title' => $input['title'],
                'body' => $input['message'],
            ];
            $this->notification->_pushNotification('android', $androidTokens, $notificationData);
        }
        if (count($iosTokens)) {
            $notificationData = [
                'badge' => 1,
                'alert' => $input['message'],
            ];

            foreach ($iosTokens as $token) {
                $this->notification->_pushNotification('ios', $token, $notificationData);
            }
        }

        //Create the model using repository create method
        $this->repository->create($input);

        //return with successfull message
        return new RedirectResponse(route('admin.loudhailers.index'), ['flash_success' => trans('alerts.backend.loudhailers.created')]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\LoudHailer\LoudHailer  $loudhailer
     * @param  EditLoudHailerRequestNamespace  $request
     * @return \App\Http\Responses\Backend\LoudHailer\EditResponse
     */
    public function edit(LoudHailer $loudhailer, EditLoudHailerRequest $request)
    {
        return new EditResponse($loudhailer);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateLoudHailerRequestNamespace  $request
     * @param  App\Models\LoudHailer\LoudHailer  $loudhailer
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(UpdateLoudHailerRequest $request, LoudHailer $loudhailer)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Update the model using repository update method
        $this->repository->update( $loudhailer, $input );
        //return with successfull message
        return new RedirectResponse(route('admin.loudhailers.index'), ['flash_success' => trans('alerts.backend.loudhailers.updated')]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteLoudHailerRequestNamespace  $request
     * @param  App\Models\LoudHailer\LoudHailer  $loudhailer
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(LoudHailer $loudhailer, DeleteLoudHailerRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($loudhailer);
        //returning with successfull message
        return new RedirectResponse(route('admin.loudhailers.index'), ['flash_success' => trans('alerts.backend.loudhailers.deleted')]);
    }

    public function show()
    {
        return abort(404);
    }

    public function sendMailForm()
    {
        $partnerTypes = Partner::groupBy('user_type')->pluck('user_type', 'user_type');

        $viewData = [
            "partnerTypes" => $partnerTypes
        ];
        return view('backend.loudhailers.send-mail', $viewData);
    }

    public function sendMail(Request $request)
    {
        $users = Partner::where('user_type', $request->send_to)->whereNotNull('email')->get();

        // Mail::to("milan.akbari16@gmail.com")->send(new SendMailFromAdmin($users, $request));
        foreach ($users as $key => $user) {
            Mail::to($user->email)->queue(new SendMailFromAdmin($user, $request->all()));
        }

        return new RedirectResponse(route('admin.loudhailers.sendmail'), ['flash_success' => trans('alerts.backend.loudhailers.mail-send')]);
    }
}
