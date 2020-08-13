<?php

namespace App\Repositories\Backend\RewardsTC;

use DB;
use Carbon\Carbon;
use App\Models\RewardsTC\RewardsTC;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RewardsTCRepository.
 */
class RewardsTCRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = RewardsTC::class;

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
                config('module.rewardstcs.table').'.id',
                config('module.rewardstcs.table').'.title',
                config('module.rewardstcs.table').'.content',
                config('module.rewardstcs.table').'.created_at',
                config('module.rewardstcs.table').'.updated_at',
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
        if (RewardsTC::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.rewardstcs.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param RewardsTC $rewardstc
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(RewardsTC $rewardstc, array $input)
    {
    	if ($rewardstc->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.rewardstcs.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param RewardsTC $rewardstc
     * @throws GeneralException
     * @return bool
     */
    public function delete(RewardsTC $rewardstc)
    {
        if ($rewardstc->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.rewardstcs.delete_error'));
    }
}
