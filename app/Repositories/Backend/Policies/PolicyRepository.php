<?php

namespace App\Repositories\Backend\Policies;

use DB;
use Carbon\Carbon;
use App\Models\Policies\Policy;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PolicyRepository.
 */
class PolicyRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Policy::class;

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
                config('module.policies.table').'.id',
                config('module.policies.table').'.created_at',
                config('module.policies.table').'.updated_at',
            ]);
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
        if (Policy::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.policies.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Policy $policy
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Policy $policy, array $input)
    {
    	if ($policy->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.policies.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Policy $policy
     * @throws GeneralException
     * @return bool
     */
    public function delete(Policy $policy)
    {
        if ($policy->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.policies.delete_error'));
    }
}
