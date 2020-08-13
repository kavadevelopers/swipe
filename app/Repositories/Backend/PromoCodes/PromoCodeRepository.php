<?php

namespace App\Repositories\Backend\PromoCodes;

use DB;
use Carbon\Carbon;
use App\Models\PromoCodes\PromoCode;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PromoCodeRepository.
 */
class PromoCodeRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = PromoCode::class;

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
                config('module.promocodes.table').'.id',
                config('module.promocodes.table').'.created_by',
                config('module.promocodes.table').'.status',
                config('module.promocodes.table').'.promo_code',
                config('module.promocodes.table').'.count_limit',
                config('module.promocodes.table').'.start_date',
                config('module.promocodes.table').'.end_date',
                config('module.promocodes.table').'.created_at',
                config('module.promocodes.table').'.updated_at',
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
        if (PromoCode::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.promocodes.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param PromoCode $promocode
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(PromoCode $promocode, array $input)
    {
    	if ($promocode->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.promocodes.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param PromoCode $promocode
     * @throws GeneralException
     * @return bool
     */
    public function delete(PromoCode $promocode)
    {
        if ($promocode->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.promocodes.delete_error'));
    }
}
