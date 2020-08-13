<?php

namespace App\Repositories\Backend\PartnerRedemption;

use DB;
use Carbon\Carbon;
use App\Models\PartnerRedemption\PartnerRedemption;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PartnerRedemptionRepository.
 */
class PartnerRedemptionRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = PartnerRedemption::class;

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
                config('module.partnerredemptions.table').'.id',
                config('module.partnerredemptions.table').'.date_time',
                config('module.partnerredemptions.table').'.name',
                config('module.partnerredemptions.table').'.address',
                config('module.partnerredemptions.table').'.status',
            ])->where('status', '=', 'pending' )->where('type','redemption');
    }
    
    public function getOnboardingForDataTable()
    {
        return $this->query()
            ->select([
                config('module.partnerredemptions.table').'.id',
                config('module.partnerredemptions.table').'.date_time',
                config('module.partnerredemptions.table').'.name',
                config('module.partnerredemptions.table').'.address',
                config('module.partnerredemptions.table').'.status',
            ])->where('status', '=', 'pending' )->where('type','onboarding');
    }
    
    public function getHistoryForDataTable()
    {
        return $this->query()
            ->select([
                config('module.partnerredemptions.table').'.id',
                config('module.partnerredemptions.table').'.date_time',
                config('module.partnerredemptions.table').'.name',
                config('module.partnerredemptions.table').'.address',
                config('module.partnerredemptions.table').'.status',
            ])->where('status', '!=', 'pending' )->where('type','redemption');
    }
    
    public function getOnboardingHistoryForDataTable()
    {
        return $this->query()
            ->select([
                config('module.partnerredemptions.table').'.id',
                config('module.partnerredemptions.table').'.date_time',
                config('module.partnerredemptions.table').'.name',
                config('module.partnerredemptions.table').'.address',
                config('module.partnerredemptions.table').'.status',
            ])->where('status', '!=', 'pending' )->where('type','onboarding');
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
        if (PartnerRedemption::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.partnerredemptions.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param PartnerRedemption $partnerredemption
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(PartnerRedemption $partnerredemption, array $input)
    {
    	if ($partnerredemption->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.partnerredemptions.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param PartnerRedemption $partnerredemption
     * @throws GeneralException
     * @return bool
     */
    public function delete(PartnerRedemption $partnerredemption)
    {
        if ($partnerredemption->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.partnerredemptions.delete_error'));
    }
}
