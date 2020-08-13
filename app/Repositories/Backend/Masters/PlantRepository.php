<?php

namespace App\Repositories\Backend\Masters;

use DB;
use Carbon\Carbon;
use App\Models\Masters\Plant;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PlantRepository.
 */
class PlantRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Plant::class;

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
                config('module.plants.table').'.id',
                config('module.plants.table').'.plant_code',
                config('module.plants.table').'.plant_name',
                config('module.plants.table').'.plant_address',
                config('module.plants.table').'.created_at',
                config('module.plants.table').'.updated_at',
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
        if (Plant::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.masters.plants.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Plant $plant
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Plant $plant, array $input)
    {
    	if ($plant->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.masters.plants.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Plant $plant
     * @throws GeneralException
     * @return bool
     */
    public function delete(Plant $plant)
    {
        if ($plant->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.masters.plants.delete_error'));
    }
}
