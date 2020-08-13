<?php

namespace App\Repositories\Backend\Configurations;

use DB;
use Carbon\Carbon;
use App\Models\Configurations\Courier;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CourierRepository.
 */
class CourierRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Courier::class;

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
                config('module.couriers.table').'.id',
                config('module.couriers.table').'.courier_box_weight_20x20x28',
                config('module.couriers.table').'.courier_box_weight_30x28x25',
                config('module.couriers.table').'.courier_box_weight_41x33x34',
                config('module.couriers.table').'.courier_box_weight_61x41x47',
                config('module.couriers.table').'.created_by',
                config('module.couriers.table').'.updated_by',
                config('module.couriers.table').'.created_at',
                config('module.couriers.table').'.updated_at',
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
        if (Courier::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.configurations.couriers.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Courier $courier
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Courier $courier, array $input)
    {
    	if ($courier->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.couriers.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Courier $courier
     * @throws GeneralException
     * @return bool
     */
    public function delete(Courier $courier)
    {
        if ($courier->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.couriers.delete_error'));
    }
}
