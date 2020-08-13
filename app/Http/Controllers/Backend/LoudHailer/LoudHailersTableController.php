<?php

namespace App\Http\Controllers\Backend\LoudHailer;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\LoudHailer\LoudHailerRepository;
use App\Http\Requests\Backend\LoudHailer\ManageLoudHailerRequest;
use App\Models\Access\User\User;

/**
 * Class LoudHailersTableController.
 */
class LoudHailersTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var LoudHailerRepository
     */
    protected $loudhailer;

    /**
     * contructor to initialize repository object
     * @param LoudHailerRepository $loudhailer;
     */
    public function __construct(LoudHailerRepository $loudhailer)
    {
        $this->loudhailer = $loudhailer;
    }

    /**
     * This method return the data of the model
     * @param ManageLoudHailerRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageLoudHailerRequest $request)
    {
        return Datatables::of($this->loudhailer->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($loudhailer) {
                return Carbon::parse($loudhailer->created_at)->format('M d, Y H:i:s');
            })
            ->addColumn('sendBy', function ($loudhailer) {
                $sender = User::find($loudhailer->send_by);
                return $sender->fullname();
            })
            ->make(true);
    }
}
