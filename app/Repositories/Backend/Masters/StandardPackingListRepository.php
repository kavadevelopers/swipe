<?php

namespace App\Repositories\Backend\Masters;

use DB;
use Carbon\Carbon;
use App\Models\Masters\StandardPackingList;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StandardPackingListRepository.
 */
class StandardPackingListRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = StandardPackingList::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->leftjoin(config('access.users_table'), config('access.users_table').'.id', '=', config('module.standardpackinglists.table').'.created_by')
            ->select([
                config('module.standardpackinglists.table').'.id',
                config('module.standardpackinglists.table').'.fgcode',
                config('module.standardpackinglists.table').'.description',
                config('module.standardpackinglists.table').'.material_group',
                config('module.standardpackinglists.table').'.20x20x28',
                config('module.standardpackinglists.table').'.30x28x25',
                config('module.standardpackinglists.table').'.41x33x34',
                config('module.standardpackinglists.table').'.61x41x47',
                config('module.standardpackinglists.table').'.created_by',
                config('module.standardpackinglists.table').'.created_at',
                config('module.standardpackinglists.table').'.updated_at',
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
        if (StandardPackingList::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.masters.standardpackinglists.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param StandardPackingList $standardpackinglist
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(StandardPackingList $standardpackinglist, array $input)
    {
    	if ($standardpackinglist->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.masters.standardpackinglists.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param StandardPackingList $standardpackinglist
     * @throws GeneralException
     * @return bool
     */
    public function delete(StandardPackingList $standardpackinglist)
    {
        if ($standardpackinglist->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.masters.standardpackinglists.delete_error'));
    }
}
