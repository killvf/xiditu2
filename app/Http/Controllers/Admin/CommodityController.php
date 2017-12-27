<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\ControllerREST;
use Illuminate\Support\Facades\DB;

class CommodityController extends ControllerREST {
    
    protected $model = 'App\Models\AgentCommodity';

    protected $controller = 'admin.commodity';

    protected $fieldValidation = [
        'name' => 'required',
        'unit_price' => 'required',
    ];

    /**
     * 添加商品
     *
     * @param Request $request
     * @return void
     */
    public function doAdd(Request $request) {
        $data = $request->all();
        $pics = $data['pics'];

        //去掉没用的字段
        unset($data['pics']);
        unset($data['file']);
        $this->validate($request, $this->fieldValidation);

        $data['unit_price'] = intval(floatval($data['unit_price']) * 100);
        DB::transaction(function() use ($data, $pics) {
           $commodity = $this->iModel->create($data);
           $id = $commodity->id;
           //向图片表中加入数据
           $pics = explode(',', $pics);
           $ndata = [];
           foreach($pics as $index=>$pic) {
               $ndata[] = [
                   'agent_commodity_id' => $id,
                   'title' => $data['name'],
                   'url' => $pic,
                   'position' => $index,
               ];
           }
           DB::table('agent_commodity_pictures')->insert($ndata);
        });
        return redirect()->route('staff.commodity.lists');
    }
   

    public function doModify(Request $request, $id) {
        $data = $request->all();
        $pics = $data['pics'];
        //去掉没用的字段
        unset($data['pics']);
        unset($data['file']);
        $this->validate($request, $this->fieldValidation);

        if(!empty($data['unit_price'])) {
            $data['unit_price'] = intval(floatval($data['unit_price']) * 100);
        }
        DB::transaction(function() use ($id, $data, $pics) {
            //先把图片删掉，再重新放进去
            DB::table('agent_commodity_pictures')->where('agent_commodity_id', $id)->delete();
            //修改数据
            $commodity = $this->iModel->find($id);
           $commodity->update($data);
           //向图片表中加入数据
           $pics = explode(',', $pics);
           $ndata = [];
           foreach($pics as $index=>$pic) {
               $ndata[] = [
                   'agent_commodity_id' => $id,
                   'title' => $data['name'],
                   'url' => $pic,
                   'position' => $index,
               ];
           }
           if(!empty($ndata)){
               DB::table('agent_commodity_pictures')->insert($ndata);
           }
        });
        return redirect()->route('staff.commodity.lists');
    }

}
