<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ControllerREST;
use App\Models\Languages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InviteController extends ControllerREST
{
    //
    protected $model = 'App\Models\Invites';

    protected $controller = 'admin.invite';

    protected $fieldValidation = [
        'language' => 'required',
        'name' => 'required',
    ];

    protected $redirectUrlAlias = 'staff.invite.lists';

    public function listExternalData() {
        //得到所有语言包
        $languages = Languages::all();
        $languages = array_column($languages->toArray(), 'name', 'english');
        return ['languages' => $languages];
    }

    public function addExternalData()
    {
       return $this->listExternalData();
    }

    public function modifyExternalData()
    {
        return $this->listExternalData();
    }

}
