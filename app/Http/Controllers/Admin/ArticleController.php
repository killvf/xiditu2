<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ControllerREST;
use App\Models\Languages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends ControllerREST
{
    //
    protected $model = 'App\Models\Articles';

    protected $controller = 'admin.article';

    protected $fieldValidation = [
        'language' => 'required',
        'title' => 'required',
    ];

    protected $redirectUrlAlias = 'staff.article.lists';

    /**
     * 上传文件地址
     * @var array
     */
    protected $fileFields = [
        'picture' => 'uploads'
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
