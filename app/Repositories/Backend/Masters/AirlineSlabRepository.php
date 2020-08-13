<?php

namespace App\Repositories\Backend\Masters;

use DB;
use Carbon\Carbon;
use App\Models\Masters\AirlineSlab;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AirlineSlabRepository.
 */
class AirlineSlabRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = AirlineSlab::class;

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
                config('module.airlineslabs.table').'.id',
                config('module.airlineslabs.table').'.destination',
                config('module.airlineslabs.table').'.ff',
                config('module.airlineslabs.table').'.airline',
                config('module.airlineslabs.table').'.tt_days',
                config('module.airlineslabs.table').'.sl',
                config('module.airlineslabs.table').'.slab',
                config('module.airlineslabs.table').'.weight_kg',
                config('module.airlineslabs.table').'.basic_rate_kg',
                config('module.airlineslabs.table').'.fsc_kg',
                config('module.airlineslabs.table').'.scc',
                config('module.airlineslabs.table').'.msc_min',
                config('module.airlineslabs.table').'.msc_kg',
                config('module.airlineslabs.table').'.x_ray_min',
                config('module.airlineslabs.table').'.x_ray_kg',
                config('module.airlineslabs.table').'.oth_min',
                config('module.airlineslabs.table').'.oth_kg',
                config('module.airlineslabs.table').'.cgc_ams_hawb_mawb',
                config('module.airlineslabs.table').'.awb_pca',
                config('module.airlineslabs.table').'.handling',
                config('module.airlineslabs.table').'.gmax',
                config('module.airlineslabs.table').'.amd_bom_min',
                config('module.airlineslabs.table').'.amd_bom_kg',
                config('module.airlineslabs.table').'.total_rs_per_shipment',
                config('module.airlineslabs.table').'.per_kgs',
                config('module.airlineslabs.table').'.expected_discount',
                config('module.airlineslabs.table').'.exp_discounted_rate_shipment',
                config('module.airlineslabs.table').'.target_basic_rate_kg',
                config('module.airlineslabs.table').'.created_at',
                config('module.airlineslabs.table').'.updated_at',
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
        if (AirlineSlab::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.airlineslabs.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param AirlineSlab $airlineslab
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(AirlineSlab $airlineslab, array $input)
    {
    	if ($airlineslab->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.airlineslabs.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param AirlineSlab $airlineslab
     * @throws GeneralException
     * @return bool
     */
    public function delete(AirlineSlab $airlineslab)
    {
        if ($airlineslab->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.airlineslabs.delete_error'));
    }
}
