<?php

namespace App\Http\Responses\Backend\Masters;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\Masters\AirlineSlab
     */
    protected $airlineslabs;

    /**
     * @param App\Models\Masters\AirlineSlab $airlineslabs
     */
    public function __construct($airlineslabs)
    {
        $this->airlineslabs = $airlineslabs;
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
        return view('backend.airlineslabs.edit')->with([
            'airlineslabs' => $this->airlineslabs
        ]);
    }
}