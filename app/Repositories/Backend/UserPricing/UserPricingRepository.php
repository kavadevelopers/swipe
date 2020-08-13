<?php

namespace App\Repositories\Backend\UserPricing;

use DB;
use Carbon\Carbon;
use App\Models\UserPricing\UserPricing;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserPricingRepository.
 */
class UserPricingRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = UserPricing::class;

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
                config('module.userpricings.table').'.id',
                config('module.userpricings.table').'.vehical_name',
                config('module.userpricings.table').'.user_price',
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
        if (UserPricing::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.userpricings.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param UserPricing $userpricing
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(UserPricing $userpricing, array $input)
    {
    	if ($userpricing->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.userpricings.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param UserPricing $userpricing
     * @throws GeneralException
     * @return bool
     */
    public function delete(UserPricing $userpricing)
    {
        if ($userpricing->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.userpricings.delete_error'));
    }
}
