<?php

namespace App\Http\Responses\Backend\Vehicle;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\Vehicle\Vehicle
     */
    protected $vehicles;

    /**
     * @param App\Models\Vehicle\Vehicle $vehicles
     */
    public function __construct($vehicles)
    {
        $this->vehicles = $vehicles;
    }

    /**
     * To Response
     *
     * @param \App\Http\Requests\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toResponse($request)
    {
        return view('backend.vehicles.edit')->with([
            'vehicles' => $this->vehicles
        ]);
    }
}