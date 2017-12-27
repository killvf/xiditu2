<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerREST extends Controller {
    /**
     * 模型名
     *
     * @var [type]
     */
    protected $model;

    /**
     * 核验字段
     *
     * @var array
     */
    protected $fieldValidation=[];

    protected $updateFieldValidation = [];
    /**
     * 模型实例
     *
     * @var [type]
     */
    protected $iModel;

    /**
     * 修改视图
     *
     * @var [type]
     */
    protected $modifyView='modify';

    /**
     * 添加的视图
     *
     * @var string
     */
    protected $addView = 'add';

    /**
     * 列表的视图
     *
     * @var string
     */
    protected $listView = 'index';

    /**
     * 重定向路由别名
     *
     * @var string
     */
    protected $redirectUrlAlias = '';

    /**
     * 重定向路由参数
     * @var array
     */
    protected $redirectParams = [];

    /**
     * 查询条件
     *
     * @var array
     */
    protected $conditions = [];

    /**
     * 上传文件的字段名
     * @var array
     */
    protected $fileFields = [
//        'filename' => 'save_path'
    ];

    public function __construct(Request $request) {
        parent::__construct($request);
        $this->iModel = new $this->model();
    }

    /**
     * 得到额外的变量
     *
     * @return void
     */
    public function addExternalData() {
        return [];
    }

    /**
     * 修改时添加的额外参数
     *
     * @return void
     */
    public function modifyExternalData() {
        return [];
    }

    /**
     * 显示列表时添加的额外参数
     *
     * @return void
     */
    public function listExternalData() {
        return [];
    }

    /**
     * 显示修改视图
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function modify(Request $request, $id) {
        //得到agenteUser信息
        $data = $this->iModel->find($id);
        $externalData = $this->modifyExternalData();
        return view($this->controller.'.'.$this->modifyView, array_merge(['data'=>$data], $externalData));
    }

    /**
     * 修改数据
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function doModify(Request $request, $id) {
        $item = $this->iModel->find($id);
        $this->validate($request, $this->updateFieldValidation);
        $data = $this->beforeModHook($request);
        $rs = $item->update($data);
        $this->afterModHook($rs);
        // return true;
        return redirect()->route($this->redirectUrlAlias, $this->redirectParams);
    }

    /**
     * 处理额外条件
     * 
     * @param Request $request
     * @return void
     */
    public function parseQuery(Request $request) {

    }

    /**
     * 显示列表
     *
     * @param Request $request
     * @return void
     */
    public function lists(Request $request) {
        
        $this->parseQuery($request);
        $query = $this->iModel;
        if(!empty($this->conditions)) {

            foreach($this->conditions as $k => $v) {
                if(is_array($v)) {
                    switch($v) {
                        case 'in':
                            $query = $query->whereIn($k, $v[1]);
                            break;
                        case 'or':
                            $query = $query->orWhere($k, $v[1]);
                            break;
                        case 'between':
                            $query = $query->whereBetween($k, $v[1]);
                            break;
                        default:
                            $query = $query->where($k, $v[0], $v[1]);
                    }
                } else {
                    $query = $query->where($k, $v);
                }

            }
        }
        if(!empty($this->sort)) {
            foreach($this->sort as $s) {
                $query = $query->orderBy($s[0], $s[1]);
            }
        }
        $data = $query->select($this->field)->paginate($this->row);
        $externalData = $this->listExternalData();
        return view($this->controller. '.'. $this->listView, array_merge(['data'=>$data], $externalData));
    }

    /**
     * 显示添加视图
     *
     * @param Request $request
     * @return void
     */
    public function add(Request $request) {
        $externalData = $this->addExternalData();
        return view($this->controller.'.'.$this->addView, $externalData);
    }

    /**
     * 添加事件
     *
     * @param Request $request
     * @return void
     */
    public function doAdd(Request $request) {
        $this->validate($request, $this->fieldValidation);
        $data = $this->beforeAddHook($request);
        $rs = $this->iModel->create($data);
        $this->afterAddHook($rs);
        // return true;
        return redirect()->route($this->redirectUrlAlias, $this->redirectParams);
    }

    protected function afterAddHook($rs) {

    }

    protected function afterModHook($rs) {

    }

    /**
     * 添加前钩子
     * @param Request $request
     */
    protected function beforeAddHook(Request $request) {
        $data = $this->processFile($request);
        return $data;
    }

    /**
     * 处理文件
     * @param Request $request
     */
    protected function processFile(Request $request) {
        $data = $request->all();
        foreach($this->fileFields as $filename => $savePath) {
            if($request->hasFile($filename)) {
                $file = $request->file($filename);
                if($file->isValid()) {
                    $path = $file->store($savePath, 'uploads');
                    //把文件字段压入到request中去
                    $data[$filename] = $path;
                }
            }
        }
        return $data;
    }

    /**
     * 更新前钩子
     * @param Request $request
     */
    protected function beforeModHook(Request $request) {
        $data = $this->processFile($request);
        return $data;
    }

    /**
     * 删除记录
     *
     * @param Request $request
     * @return void
     */
    public function delete(Request $request) {
        $id = $request->input('id');
        $data = $this->iModel->find($id);
        if(!empty($data)) {
            $data->delete();
            return $this->apiData([]);
        }
        return $this->apiErr('记录不存在');
    }
}
