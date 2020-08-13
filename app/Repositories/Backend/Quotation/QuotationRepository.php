<?php

namespace App\Repositories\Backend\Quotation;

use DB;
use Carbon\Carbon;
use App\Models\Quotation\Quotation;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class QuotationRepository.
 */
class QuotationRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Quotation::class;

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
                config('module.quotations.table').'.id',
                config('module.quotations.table').'.created_at',
                config('module.quotations.table').'.updated_at',
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
        if (Quotation::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.quotations.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Quotation $quotation
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Quotation $quotation, array $input)
    {
    	if ($quotation->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.quotations.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Quotation $quotation
     * @throws GeneralException
     * @return bool
     */
    public function delete(Quotation $quotation)
    {
        if ($quotation->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.quotations.delete_error'));
    }
}
