<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Access\Permission\Permission;
use App\Models\Access\Role\Role;
use App\Models\Access\User\User;
use App\Models\Settings\Setting;
use App\Models\Estimate\Estimate;
use App\Models\Quotation\Quotation;
use Illuminate\Http\Request;

use App\Models\UsersList\UserList;
use App\Models\CarWashBooking\CarWashBooking;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $settingData = Setting::first();
        $users = UserList::get();
        $bookings = CarWashBooking::get();
        $viewData = [
            "users" => [
                "total" => $users->where('user_type', 'user')->count(),
                "suspended" => $users->where('user_type', 'user')->where('status', 2)->count()
            ],
            "partners" => [
                "total" => $users->where('user_type', 'washer')->count(),
                "pending" => $users->where('user_type', 'washer')->where('status', 0)->count(),
                "suspended" => $users->where('user_type', 'washer')->where('status', 2)->count()
            ],
            "bookings" => [
                "total" => $bookings->count(),
                "pending" => $bookings->where('status', 'Pending')->count(),
                // "in-progress" => $bookings->where('status', 'Completed')->count(),
                "completed" => $bookings->where('status', 'Completed')->count(),
                "cancelled" => $bookings->where('status', 'Cancelled')->count(),
                "expired" => $bookings->where('status', 'Expired')->count(),
            ]
        ];

        return view('backend.dashboard', $viewData);


        //return view('backend.dashboard', compact('google_analytics', $google_analytics,));
    }

    /**
     * Used to display form for edit profile.
     *
     * @return view
     */
    public function editProfile(Request $request)
    {
        $status = array(
            0 => 'In Active',
            1 => 'Active'
        );

        return view('backend.access.users.profile-edit')->with('status',$status)
            ->withLoggedInUser(access()->user());
    }

    /**
     * Used to update profile.
     *
     * @return view
     */
    public function updateProfile(Request $request)
    {
        $input = $request->all();
        $userId = access()->user()->id;
        $user = User::find($userId);
        $user->first_name = $input['first_name'];
        $user->contact_no = $input['contact_no'];
        $user->emergency_name = $input['emergency_name'];
        $user->emergency_relationship = $input['emergency_relationship'];
        $user->emergency_contact = $input['emergency_contact'];
        
        $user->updated_by = access()->user()->id;

        if ($user->save()) {
            return redirect()->route('admin.profile.edit')
                ->withFlashSuccess(trans('labels.backend.profile_updated'));
        }
    }

    /**
     * This function is used to get permissions details by role.
     *
     * @param Request $request
     */
    public function getPermissionByRole(Request $request)
    {
        if ($request->ajax()) {
            $role_id = $request->get('role_id');
            $rsRolePermissions = Role::where('id', $role_id)->first();
            $rolePermissions = $rsRolePermissions->permissions->pluck('display_name', 'id')->all();
            $permissions = Permission::pluck('display_name', 'id')->all();
            ksort($rolePermissions);
            ksort($permissions);
            $results['permissions'] = $permissions;
            $results['rolePermissions'] = $rolePermissions;
            $results['allPermissions'] = $rsRolePermissions->all;
            echo json_encode($results);
            die;
        }
    }

    public function getEstimateCount(Request $request){
        $estimate = Estimate::count();

        return view('backend.dashboard')
                    ->with([
                        'estimate' => $estimate
                    ]);

        //return view('backend.dashboard', compact('estimate'));
    }
}
