<?php

namespace App\Http\Responses\Backend\RewardsTC;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\RewardsTC\RewardsTC
     */
    protected $rewardstcs;

    /**
     * @param App\Models\RewardsTC\RewardsTC $rewardstcs
     */
    public function __construct($rewardstcs)
    {
        $this->rewardstcs = $rewardstcs;
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
        return view('backend.rewardstcs.edit')->with([
            'rewardstcs' => $this->rewardstcs
        ]);
    }
}