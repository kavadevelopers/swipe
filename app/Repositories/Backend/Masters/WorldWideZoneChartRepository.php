<?php

namespace App\Repositories\Backend\Masters;

use DB;
use Carbon\Carbon;
use App\Models\Masters\WorldWideZoneChart;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WorldWideZoneChartRepository.
 */
class WorldWideZoneChartRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = WorldWideZoneChart::class;

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
                config('module.worldwidezonecharts.table').'.id',
                config('module.worldwidezonecharts.table').'.destination',
                config('module.worldwidezonecharts.table').'.express_plus',
                config('module.worldwidezonecharts.table').'.express',
                config('module.worldwidezonecharts.table').'.express_saver',
                config('module.worldwidezonecharts.table').'.expedited',
                config('module.worldwidezonecharts.table').'.created_at',
                config('module.worldwidezonecharts.table').'.updated_at',
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
        if (WorldWideZoneChart::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.worldwidezonecharts.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param WorldWideZoneChart $worldwidezonechart
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(WorldWideZoneChart $worldwidezonechart, array $input)
    {
    	if ($worldwidezonechart->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.worldwidezonecharts.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param WorldWideZoneChart $worldwidezonechart
     * @throws GeneralException
     * @return bool
     */
    public function delete(WorldWideZoneChart $worldwidezonechart)
    {
        if ($worldwidezonechart->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.worldwidezonecharts.delete_error'));
    }
}
