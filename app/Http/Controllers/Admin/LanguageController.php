<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ControllerREST;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LanguageController extends ControllerREST
{
    //

    protected $model = 'App\Models\Languages';

    protected $controller = 'admin.languages';

    protected $fieldValidation = [
        'name' => 'required',
        'english' => 'required',
    ];

    protected $redirectUrlAlias = 'staff.language.lists';

}
