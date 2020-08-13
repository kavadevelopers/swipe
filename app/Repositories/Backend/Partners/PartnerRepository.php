<?php

namespace App\Repositories\Backend\Partners;

use DB;
use Carbon\Carbon;
use App\Models\Partners\Partner;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PartnerRepository.
 */
class PartnerRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Partner::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->select('*')->with('bankDetail')->where('user_type', '=', 'washer')->where('status',0);
        // return Partner::where('user_type', '=', 'user')->get();
    }
    
    public function getForDataTablePending()
    {
        return $this->query()
            ->select('*')->with('bankDetail','adminDetail')->where('user_type', '=', 'washer')->where('status',1)->where('payment_status',0);
        // return Partner::where('user_type', '=', 'user')->get();
    }
    public function getForDataTableConfirm()
    {
        return $this->query()
            ->select('*')->with('bankDetail','adminDetail')->where('user_type', '=', 'washer')->where('status',1);
        // return Partner::where('user_type', '=', 'user')->get();
    }
    public function getForDataTableHistory()
    {
        return $this->query()
            ->select('*')->with('bankDetail','adminDetail')->where('user_type', '=', 'washer')->where('status',1);
        // return Partner::where('user_type', '=', 'user')->get();
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
        if (Partner::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.partners.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Partner $partner
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Partner $partner, array $input)
    {
    	if ($partner->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.partners.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Partner $partner
     * @throws GeneralException
     * @return bool
     */
    public function delete(Partner $partner)
    {
        if ($partner->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.partners.delete_error'));
    }
}
