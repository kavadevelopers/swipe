<?php

namespace App\Repositories\Backend\Masters;

use DB;
use Carbon\Carbon;
use App\Models\Masters\ExpressSaver;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ExpressSaverRepository.
 */
class ExpressSaverRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = ExpressSaver::class;

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
                config('module.expresssavers.table').'.id',
                config('module.expresssavers.table').'.zone',
                config('module.expresssavers.table').'.1',
                config('module.expresssavers.table').'.2',
                config('module.expresssavers.table').'.3',
                config('module.expresssavers.table').'.4',
                config('module.expresssavers.table').'.5',
                config('module.expresssavers.table').'.6',
                config('module.expresssavers.table').'.7',
                config('module.expresssavers.table').'.8',
                config('module.expresssavers.table').'.9',
                config('module.expresssavers.table').'.created_at',
                config('module.expresssavers.table').'.updated_at',
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
        if (ExpressSaver::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.expresssavers.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param ExpressSaver $expresssaver
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(ExpressSaver $expresssaver, array $input)
    {
    	if ($expresssaver->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.expresssavers.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param ExpressSaver $expresssaver
     * @throws GeneralException
     * @return bool
     */
    public function delete(ExpressSaver $expresssaver)
    {
        if ($expresssaver->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.expresssavers.delete_error'));
    }
}
