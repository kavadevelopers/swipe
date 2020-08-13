<?php

namespace App\Repositories\Backend\Expenditure;

use DB;
use Carbon\Carbon;
use App\Models\Expenditure\Expenditure;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ExpenditureRepository.
 */
class ExpenditureRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Expenditure::class;

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
                config('module.expenditures.table').'.id',
                config('module.expenditures.table').'.created_at',
                config('module.expenditures.table').'.updated_at',
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
        if (Expenditure::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.expenditures.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Expenditure $expenditure
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Expenditure $expenditure, array $input)
    {
    	if ($expenditure->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.expenditures.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Expenditure $expenditure
     * @throws GeneralException
     * @return bool
     */
    public function delete(Expenditure $expenditure)
    {
        if ($expenditure->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.expenditures.delete_error'));
    }
}
