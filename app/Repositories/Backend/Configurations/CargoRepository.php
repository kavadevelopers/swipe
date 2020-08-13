<?php

namespace App\Repositories\Backend\Configurations;

use DB;
use Carbon\Carbon;
use App\Models\Configurations\Cargo;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CargoRepository.
 */
class CargoRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Cargo::class;

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
                config('module.cargos.table').'.id',
                config('module.cargos.table').'.cargo_box_weight_20x20x28',
                config('module.cargos.table').'.cargo_box_weight_30x28x25',
                config('module.cargos.table').'.cargo_box_weight_41x33x34',
                config('module.cargos.table').'.cargo_box_weight_61x41x47',
                config('module.cargos.table').'.created_by',
                config('module.cargos.table').'.updated_by',
                config('module.cargos.table').'.created_at',
                config('module.cargos.table').'.updated_at',
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
        if (Cargo::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.cargos.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Cargo $cargo
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Cargo $cargo, array $input)
    {
    	if ($cargo->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.cargos.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Cargo $cargo
     * @throws GeneralException
     * @return bool
     */
    public function delete(Cargo $cargo)
    {
        if ($cargo->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.cargos.delete_error'));
    }
}
