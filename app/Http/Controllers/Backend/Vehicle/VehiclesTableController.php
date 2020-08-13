<?php

namespace App\Http\Controllers\Backend\Vehicle;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\Vehicle\VehicleRepository;
use App\Http\Requests\Backend\Vehicle\ManageVehicleRequest;

/**
 * Class VehiclesTableController.
 */
class VehiclesTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var VehicleRepository
     */
    protected $vehicle;

    /**
     * contructor to initialize repository object
     * @param VehicleRepository $vehicle;
     */
    public function __construct(VehicleRepository $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    /**
     * This method return the data of the model
     * @param ManageVehicleRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageVehicleRequest $request)
    {
        return Datatables::of($this->vehicle->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('created_at', function ($vehicle) {
                return Carbon::parse($vehicle->created_at)->toDateString();
            })
            ->addColumn('actions', function ($vehicle) {
                return $vehicle->action_buttons;
            })
            ->make(true);
    }
}
