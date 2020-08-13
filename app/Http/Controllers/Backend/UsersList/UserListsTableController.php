<?php

namespace App\Http\Controllers\Backend\UsersList;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\UsersList\UserListRepository;
use App\Http\Requests\Backend\UsersList\ManageUserListRequest;

/**
 * Class UserListsTableController.
 */
class UserListsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var UserListRepository
     */
    protected $userlist;

    /**
     * contructor to initialize repository object
     * @param UserListRepository $userlist;
     */
    public function __construct(UserListRepository $userlist)
    {
        $this->userlist = $userlist;
    }

    /**
     * This method return the data of the model
     * @param ManageUserListRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageUserListRequest $request)
    {
        return Datatables::of($this->userlist->getForDataTable()->where('user_type', 'user'))
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($userlist) {
                return Carbon::parse($userlist->created_at)->toDateString();
            })
            ->make(true);
    }
}
