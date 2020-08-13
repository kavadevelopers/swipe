<?php

namespace App\Repositories\Backend\PartnerPricing;

use DB;
use Carbon\Carbon;
use App\Models\PartnerPricing\PartnerPricing;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PartnerPricingRepository.
 */
class PartnerPricingRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = PartnerPricing::class;

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
                config('module.userpricings.table').'.id',
                config('module.userpricings.table').'.vehical_name',
                config('module.userpricings.table').'.partner_price',
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
        if (PartnerPricing::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.partnerpricings.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param PartnerPricing $partnerpricing
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(PartnerPricing $partnerpricing, array $input)
    {
    	if ($partnerpricing->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.partnerpricings.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param PartnerPricing $partnerpricing
     * @throws GeneralException
     * @return bool
     */
    public function delete(PartnerPricing $partnerpricing)
    {
        if ($partnerpricing->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.partnerpricings.delete_error'));
    }
}
