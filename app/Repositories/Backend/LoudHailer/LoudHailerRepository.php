<?php

namespace App\Repositories\Backend\LoudHailer;

use DB;
use Carbon\Carbon;
use App\Models\LoudHailer\LoudHailer;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LoudHailerRepository.
 */
class LoudHailerRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = LoudHailer::class;

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
                config('module.loudhailers.table').'.id',
                config('module.loudhailers.table').'.title',
                config('module.loudhailers.table').'.send_to',
                config('module.loudhailers.table').'.send_by',
                config('module.loudhailers.table').'.message',
                config('module.loudhailers.table').'.created_at',
                config('module.loudhailers.table').'.updated_at',
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
        if (LoudHailer::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.loudhailers.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param LoudHailer $loudhailer
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(LoudHailer $loudhailer, array $input)
    {
    	if ($loudhailer->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.loudhailers.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param LoudHailer $loudhailer
     * @throws GeneralException
     * @return bool
     */
    public function delete(LoudHailer $loudhailer)
    {
        if ($loudhailer->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.loudhailers.delete_error'));
    }
}
