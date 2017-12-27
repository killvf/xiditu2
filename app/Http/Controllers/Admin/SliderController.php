<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ControllerREST;
use App\Models\Languages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SliderController extends ControllerREST
{
    //
    protected $model = 'App\Models\Sliders';

    protected $controller = 'admin.slider';

    protected $fieldValidation = [
        'language' => 'required',
        'title' => 'required',
        'picture' => 'required',
    ];

    protected $redirectUrlAlias = 'staff.slider.lists';

    /**
     * 上传文件地址
     * @var array
     */
    protected $fileFields = [
        'picture' => 'sliders'
    ];

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
