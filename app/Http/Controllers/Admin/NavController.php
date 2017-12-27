<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ControllerREST;
use App\Models\Languages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NavController extends ControllerREST
{
    //
    protected $model = 'App\Models\Navs';

    protected $controller = 'admin.nav';

    protected $fieldValidation = [
        'language' => 'required',
        'title' => 'required',
        'link' => 'required',
    ];

    protected $redirectUrlAlias = 'staff.nav.lists';

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
