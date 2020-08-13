<?php

namespace App\Repositories\Backend\UsersList;

use DB;
use Carbon\Carbon;
use App\Models\UsersList\UserList;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserListRepository.
 */
class UserListRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = UserList::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->select([
                config('module.userlists.table').'.id',
                config('module.userlists.table').'.name',
                config('module.userlists.table').'.mobile',
                config('module.userlists.table').'.user_type',
                config('module.userlists.table').'.email',
                config('module.userlists.table').'.provider',
                config('module.userlists.table').'.provider_id',
                config('module.userlists.table').'.device_type',
                config('module.userlists.table').'.country_code',
                config('module.userlists.table').'.citizenship',
                config('module.userlists.table').'.dob',
                config('module.userlists.table').'.created_at',
                config('module.userlists.table').'.updated_at',
            ])->withCount('mycar','rewards');
    }

    /**
     * For Creating the respective model in storage
     *
     * @param array $input
     * @throws GeneralException
     * @return bool
     */
    public function create(array $input)
    {
        if (UserList::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.userlists.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param UserList $userlist
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(UserList $userlist, array $input)
    {
    	if ($userlist->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.userlists.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param UserList $userlist
     * @throws GeneralException
     * @return bool
     */
    public function delete(UserList $userlist)
    {
        if ($userlist->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.userlists.delete_error'));
    }
}
