<?php

namespace App\Repositories\Backend\Vehicle;

use DB;
use Carbon\Carbon;
use App\Models\Vehicle\Vehicle;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VehicleRepository.
 */
class VehicleRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Vehicle::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->select('*')->with('brandDetail','vehicalDetail');
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
        if (Vehicle::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.vehicles.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Vehicle $vehicle
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Vehicle $vehicle, array $input)
    {
    	if ($vehicle->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.vehicles.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Vehicle $vehicle
     * @throws GeneralException
     * @return bool
     */
    public function delete(Vehicle $vehicle)
    {
        if ($vehicle->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.vehicles.delete_error'));
    }
}
