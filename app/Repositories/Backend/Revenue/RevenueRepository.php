<?php

namespace App\Repositories\Backend\Revenue;

use DB;
use Carbon\Carbon;
use App\Models\Revenue\Revenue;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RevenueRepository.
 */
class RevenueRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Revenue::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->select('*')->where('user_type','washer')->where('payment_status','2')->where('status','1');
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
        if (Revenue::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.revenues.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Revenue $revenue
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Revenue $revenue, array $input)
    {
    	if ($revenue->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.revenues.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Revenue $revenue
     * @throws GeneralException
     * @return bool
     */
    public function delete(Revenue $revenue)
    {
        if ($revenue->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.revenues.delete_error'));
    }
}
