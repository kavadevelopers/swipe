<?php

namespace App\Http\Responses\Backend\UsersList;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\UsersList\UserList
     */
    protected $userlists;

    /**
     * @param App\Models\UsersList\UserList $userlists
     */
    public function __construct($userlists)
    {
        $this->userlists = $userlists;
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
        return view('backend.userlists.edit')->with([
            'userlists' => $this->userlists
        ]);
    }
}