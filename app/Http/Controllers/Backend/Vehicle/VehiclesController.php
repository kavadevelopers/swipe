<?php

namespace App\Http\Controllers\Backend\Vehicle;

use App\Models\Vehicle\Vehicle;
use App\Models\Vehicle\VehicalType;
// use App\Models\Vehicle\VehicleModel;
use App\Models\Vehicle\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\Vehicle\CreateResponse;
use App\Http\Responses\Backend\Vehicle\EditResponse;
use App\Repositories\Backend\Vehicle\VehicleRepository;
use App\Http\Requests\Backend\Vehicle\ManageVehicleRequest;
use App\Http\Requests\Backend\Vehicle\CreateVehicleRequest;
use App\Http\Requests\Backend\Vehicle\StoreVehicleRequest;
use App\Http\Requests\Backend\Vehicle\EditVehicleRequest;
use App\Http\Requests\Backend\Vehicle\UpdateVehicleRequest;
use App\Http\Requests\Backend\Vehicle\DeleteVehicleRequest;
use Validator;
use Illuminate\Support\Facades\Storage;
/**
 * VehiclesController
 */
class VehiclesController extends Controller
{
    /**
     * variable to store the repository object
     * @var VehicleRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param VehicleRepository $repository;
     */
    public function __construct(VehicleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\Vehicle\ManageVehicleRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageVehicleRequest $request)
    {
        return new ViewResponse('backend.vehicles.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param  CreateVehicleRequestNamespace  $request
     * @return \App\Http\Responses\Backend\Vehicle\CreateResponse
     */

   

    
    public function create(CreateVehicleRequest $request)
    {
        $getBrand = Brand::all();
        $brand = $getBrand->mapWithKeys(function ($item) {
            return [$item['id'] => $item['brand_name']];
        });

        $getVehical = VehicalType::all();
        $vehical = $getVehical->mapWithKeys(function ($item) {
            return [$item['id'] => $item['vehical_name']];
        });

        return view('backend.vehicles.create')->with(['brand'=>$brand, 'vehicle' => $vehical]);
        // return new CreateResponse('backend.vehicles.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreVehicleRequestNamespace  $request
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StoreVehicleRequest $request)
    {
        //Input received from the request
        // $input = $request->except(['_token']);
        //Create the model using repository create method
        // $this->repository->create($input);
        //return with successfull message
        // return new RedirectResponse(route('admin.vehicles.index'), ['flash_success' => trans('alerts.backend.vehicles.created')]);
        $input = $request->all();
        $rules = array(
            'model_name'       =>     'required|unique:carmodels',
            'model_img'        =>     'required',
            'brand_id'         =>     'required',
            'vehicletype_id'   =>     'required'
        );
        $messages = array(
                    'model_name.required'       =>      'The Model Name field is required.',
                    'model_name.required'       =>      'The Model Name has already been taken.',
                    'brand_id.required'         =>      'The Brand Name field is required.',
                    'vehicletype_id.required'   =>      'The vehicleType field is required.',
                    'model_img.required'        =>      'The Model Image field is required.',
                    'model_img.mimes'           =>      'This is not a valid image file(upload png, jpeg, jpg file).',
                );
        $validation= Validator::make($input, $rules,$messages);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)
            ->withInput();
        }
        $img =  $input['model_img'];
        // \Log::info("image ==> ".json_encode($img));
        $path = config('swip.PATH.UPLOAD_MODEL_IMAGE');
        if (!is_dir($path)) {
            $oldmask = umask(0);
            mkdir($path, 0777,true);
            umask($oldmask);
        }

        if ($img !== null) {
            $filename = "model_" . (strtotime("now").mt_rand(0,999999)) . "." . $img->getClientOriginalExtension();
            
            $img->storeAs('images\model', $filename);

            $brandArr = array(
                'model_name' => $input['model_name'],
                'model_img' => $input['model_img'],
                'brand_id' => (int)$input['brand_id'],
                'vehicletype_id' => (int)$input['vehicletype_id'],
                'model_img' => $filename,
            );
            Vehicle::create($brandArr);
        }

        return new RedirectResponse(route('admin.vehicles.index'), ['flash_success' => trans('The Model was successfully created')]);
        return view('backend.vehicles.index');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\Vehicle\Vehicle  $vehicle
     * @param  EditVehicleRequestNamespace  $request
     * @return \App\Http\Responses\Backend\Vehicle\EditResponse
     */
    public function edit($id)
    {
        $getBrand = Brand::all();
        $brand = $getBrand->mapWithKeys(function ($item) {
            return [$item['id'] => $item['brand_name']];
        });

        $getVehical = VehicalType::all();
        $vehical = $getVehical->mapWithKeys(function ($item) {
            return [$item['id'] => $item['vehical_name']];
        });

        $vehicle = Vehicle::find($id);
        return view('backend.vehicles.edit')->with([
                'vehicles'   =>  $vehicle,
                'brand'     =>  $brand, 
                'vehicle'   =>  $vehical
        ]);
        //  return new EditResponse($vehicle);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateVehicleRequestNamespace  $request
     * @param  App\Models\Vehicle\Vehicle  $vehicle
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(UpdateVehicleRequest $request, $id)
    {
        //Input received from the request
        $input = $request->all();
        $rules = array(
                    'model_name'       =>   'required|unique:carmodels',
                    'brand_id'         =>   'required',
                    'vehicletype_id'   =>   'required'
                );
        $messages = array(
                    'model_name.required'      =>   'The Model Name field is required.',
                    'model_name.unique'        =>   'The Model Name has already been taken.',
                    'brand_id.required'        =>   'The Brand Name field is required.',
                    'vehicletype_id.required'  =>   'The Vehical Type is required.',
                );
        $validation= Validator::make($input, $rules,$messages);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)
            ->withInput();
        }
        $img = isset($request->model_img) ? $input['model_img'] : null;

        $brandArr = array(
            'model_name' => $input['model_name'],
            'brand_id' => (int)$input['brand_id'],
            'vehicletype_id' => (int)$input['vehicletype_id'],
        );

        if ($img !== null) {
            $filename = "model_" . (strtotime("now").mt_rand(0,999999)) . "." . $img->getClientOriginalExtension();
            $img->storeAs('images\model', $filename);
            $brandArr['model_img'] = $filename;
        }

        Vehicle::where('id',$id)->update($brandArr);

        return new RedirectResponse(route('admin.vehicles.index'), ['flash_success' => trans('alerts.backend.vehicles.updated')]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteVehicleRequestNamespace  $request
     * @param  App\Models\Vehicle\Vehicle  $vehicle
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Vehicle $vehicle, DeleteVehicleRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($vehicle);
        //returning with successfull message
        return new RedirectResponse(route('admin.vehicles.index'), ['flash_success' => trans('alerts.backend.vehicles.deleted')]);
    }
 
    public function brand(){
        
        return view('backend.vehicles.brand');
    }

    public function brandCreate(Request $request){
        $input = $request->all();
        $rules = array(
                    'brand_name'   => 'required|unique:brands',
                    'brand_img'    => 'required',
                );
        $messages = array(
                    'brand_name.required'  =>   'The Brand Name field is required.',
                    'brand_img.unique'     =>   'The Brand Name has already been taken.',
                    'brand_img.required'   =>   'The Brand Image field is required.',
                    'brand_img.mimes'      =>   'This is not a valid image file(upload png, jpeg, jpg file).',
                );
        $validation= Validator::make($input, $rules,$messages);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)
            ->withInput();
        }
        $img =  $input['brand_img'];
        
        $path = config('swip.PATH.UPLOAD_BRAND_IMAGE');
        if (!is_dir($path)) {
            $oldmask = umask(0);
            mkdir($path, 0777,true);
            umask($oldmask);
        }

        if ($img !== null) {
            $filename = "brand_" . (strtotime("now").mt_rand(0,999999)) . "." . $img->getClientOriginalExtension();
            $img->move($path, $filename);
            $brandArr = array(
                'brand_name' => $input['brand_name'],
                'brand_img' => $filename,
            );
            Brand::create($brandArr);
        }
        return new RedirectResponse(route('admin.vehicles.brand'), ['flash_success' => trans('Brand create successfull.')]);
    }

    public function modelCreate(Request $request){
        $input = $request->all();
        $rules = array(
                    'model_name'                => 'required',
                    'model_img'                => 'required',
                    'brand_id'                  => 'required',
                    'vehicle_id'                  => 'required'
                );
        $messages = array(
                    'brand_id.required'                => 'Brand Name is required.',
                    'vehicle_id.required'                => 'Vehicle Name is required.',
                    'model_name.required'                => 'Name is required.',
                    'model_img.required'                => 'Image Required',
                    'model_img.mimes'                   => 'This is not a valid image file(upload png, jpeg, jpg file).',
                );
        $validation= Validator::make($input, $rules,$messages);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)
            ->withInput();
        }
        $img =  $input['model_img'];
        
        $path = config('swip.PATH.UPLOAD_MODEL_IMAGE');
        if (!is_dir($path)) {
            $oldmask = umask(0);
            mkdir($path, 0777,true);
            umask($oldmask);
        }

        if ($img !== null) {
            $filename = "model_" . (strtotime("now").mt_rand(0,999999)) . "." . $img->getClientOriginalExtension();
            
            $img->move($path, $filename);

            $brandArr = array(
                'model_name' => $input['model_name'],
                'model_img' => $input['model_img'],
                'brand_id' => (int)$input['brand_id'],
                'vehicle_id' => (int)$input['vehicle_id'],
                'model_img' => $filename,
            );
            Vehicle::create($brandArr);
        }

        return view('backend.vehicles.brand');
    }

    
    public function vehicle(){
        return view('backend.vehicles.vehicaltype');
    }

    public function vehicleCreate(Request $request){
        $input = $request->all();
        $rules = array(
                    'vehical_name'                => 'required|unique:vehical_types',
                    'vehical_img'                => 'required',
                    
                );
        $messages = array(
                    'vehical_name.required'                => 'The Vehical Name field is required.',
                    'vehical_name.unique'                => 'The Vehical Name has already been taken.',
                    'vehical_img.required'                => 'The Vehical Image field is required.',
                    'vehical_img.mimes'                   => 'This is not a valid image file(upload png, jpeg, jpg file).',
                );
        $validation= Validator::make($input, $rules,$messages);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)
            ->withInput();
        }
        $img =  $input['vehical_img'];
        $path = config('swip.PATH.UPLOAD_VEHICAL_IMAGE');
        if (!is_dir($path)) {
            $oldmask = umask(0);
            mkdir($path, 0777,true);
            umask($oldmask);
        }

        if ($img !== null) {
            $filename = "vehicle_" . (strtotime("now").mt_rand(0,999999)) . "." . $img->getClientOriginalExtension();
            
            $img->move($path, $filename);

            $brandArr = array(
                'vehical_name' => $input['vehical_name'],
                'vehical_img' => "",
            );
            VehicalType::create($brandArr);
        }

        return new RedirectResponse(route('admin.vehicles.vehicaltype'), ['flash_success' => trans('Vehicle create successfull.')]);
    }

}
