<?php

namespace App\Repositories\Backend\Partnerfaq;

use DB;
use Carbon\Carbon;
use App\Models\Partnerfaq\Partnerfaq;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PartnerfaqRepository.
 */
class PartnerfaqRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Partnerfaq::class;

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
                config('module.partnerfaqs.table').'.id',
                config('module.partnerfaqs.table').'.question',
                config('module.partnerfaqs.table').'.answer',
                config('module.partnerfaqs.table').'.created_at',
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
        if (Partnerfaq::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.partnerfaqs.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Partnerfaq $partnerfaq
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Partnerfaq $partnerfaq, array $input)
    {
    	if ($partnerfaq->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.partnerfaqs.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Partnerfaq $partnerfaq
     * @throws GeneralException
     * @return bool
     */
    public function delete(Partnerfaq $partnerfaq)
    {
        if ($partnerfaq->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.partnerfaqs.delete_error'));
    }
}
