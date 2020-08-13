<?php

namespace App\Repositories\Backend\Estimate;

use DB;
use Carbon\Carbon;
use App\Models\Estimate\Estimate;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EstimateRepository.
 */
class EstimateRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Estimate::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->select("*")->with('country');
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
        if (Estimate::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.estimates.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Estimate $estimate
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Estimate $estimate, array $input)
    {
    	if ($estimate->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.estimates.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Estimate $estimate
     * @throws GeneralException
     * @return bool
     */
    public function delete(Estimate $estimate)
    {
        if ($estimate->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.estimates.delete_error'));
    }
}
