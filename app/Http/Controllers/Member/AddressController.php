<?php


namespace App\Http\Controllers\Member;

use App\Http\Controllers\ControllerREST;
use App\Models\AgentDeliveryAddress;
use Illuminate\Http\Request;

class AddressController extends ControllerREST
{
    protected $model = 'App\Models\AgentDeliveryAddress';

    protected $controller = 'member.address';

    protected $sort = [['id', 'desc']];

    protected $fieldValidation = [
        'name' => 'required',
        'mobile' => 'required',
        'province' => 'required',
        'city' => 'required',
        'detail' => 'required',
    ];

    protected $updateFieldValidation = [

    ];

    public function parseQuery(Request $request) {
        $member = session('member');
        $this->conditions = [
            'agent_user_id' => $member->id,
        ];

    }

    /**
     * 添加地址
     * @param Request $request
     */
    public function doAdd(Request $request)
    {
        //重写重定向地址
        if($request->input('from') == 'address') {
            $this->redirectUrlAlias = 'member.address.index';
            $this->redirectParams = [];
        } else {
            $this->redirectUrlAlias = 'member.order.sure';
            $this->redirectParams = ['type'=>'back'];
        }
        $data = $request->all();
        if(empty($data['district'])) {
            $data['district']  = '其它';
        }
        if($request->input('default') == '1') {
            $mAddress = new AgentDeliveryAddress();
            $mAddress->cancelDefault($request->input('agent_user_id'));
        }
        $this->validate($request, $this->fieldValidation, [
            /*
             *  'name' => 'required',
        'mobile' => 'required',
        'province' => 'required',
        'city' => 'required',
        'detail' => 'required',
             */
            'name.required' => '收件人姓名必填',
            'mobile.required' => '收件人手机必填',
            'province.required' => '省必填',
            'city.required' => '市必填',
            'detail.required' => '详细地址必填',
        ]);
        $this->iModel->create($data);
        // return true;
        return redirect()->route($this->redirectUrlAlias, $this->redirectParams);
    }

    public function doModify(Request $request, $id)
    {
        //重写重定向地址
        $this->redirectUrlAlias = 'member.address.index';
        $this->redirectParams = [];
        //
        $data = $request->all();
        if($request->input('default') == '1') {
            $mAddress = new AgentDeliveryAddress();
            $mAddress->cancelDefault($request->input('agent_user_id'));
        } else {
            //如果不存在default就把default的值设置为0
            $data['default'] = 0;
        }
        if(empty($data['district'])) {
           $data['district']  = '其它';
        }
        $item = $this->iModel->find($id);
        $this->validate($request, $this->updateFieldValidation);
        $rs = $item->update($data);
        // return true;
        if($request->isXmlHttpRequest()) {
            return $this->apiData([$rs]);
        }
        return redirect()->route($this->redirectUrlAlias, $this->redirectParams);
    }

    /**
     * 用户选择地址
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function choose(Request $request) {
        $id = $request->input('id');
        if(empty($id)) {
            $member = $request->session()->get('member');
            $memberID = $member->id;
            $mAddress = new AgentDeliveryAddress();
            $addresses = $mAddress->where('agent_user_id', $memberID)->get();
            return view('member.address.choose', ['addresses' => $addresses]);
        }
        //把地址放到session
        $request->session()->put('address_id', $id);
        return redirect()->route('member.order.sure', ['type'=>'back']);
    }

}