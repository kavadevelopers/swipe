<?php

namespace App\Repositories\Backend\Liability;

use DB;
use Carbon\Carbon;
use App\Models\Liability\Liability;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LiabilityRepository.
 */
class LiabilityRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Liability::class;

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
                config('module.liabilities.table').'.id',
                config('module.liabilities.table').'.created_at',
                config('module.liabilities.table').'.updated_at',
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
        if (Liability::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.liabilities.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Liability $liability
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Liability $liability, array $input)
    {
    	if ($liability->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.liabilities.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Liability $liability
     * @throws GeneralException
     * @return bool
     */
    public function delete(Liability $liability)
    {
        if ($liability->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.liabilities.delete_error'));
    }
}
