<?php
/**
 * Created by PhpStorm.
 * User: echo
 * Date: 17-8-22
 * Time: 下午9:42
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ControllerREST;
use App\Models\AgentOrderForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends ControllerREST
{
    protected $model = 'App\Models\AgentOrderForm';

    protected $controller = 'admin.order';

    public function parseQuery(Request $request) {
        $data = $request->all();
        foreach($data as $k => $v) {
            if(trim($v) == '') {
                continue;
            }
            if($k == 'receiver_name' || $k == 'receiver_mobile') {
                $v = ['like', '%'.$v.'%'];
            }
            $this->conditions[$k] = $v;
        }
//        dd($this->conditions);
    }


    /**
     * 设置快递信息
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function post(Request $request, $id) {
        $order = $this->iModel->find($id);
        if($order->status == AgentOrderForm::STATUS_WAIT_POST) {
            if($request->isMethod('POST')) {
                DB::transaction(function() use($order, $request) {
                    $order->update($request->all());
                    $order->status = AgentOrderForm::STATUS_FINISHED;
                    $order->save();
                });
                return redirect()->route('staff.order.lists');
            }
            return view('admin.order.post', ['order'=> $order]);
        }
        return redirect()->route('staff.order.lists');
    }

    /**
     * 审核通过订单
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function check(Request $request, $id) {
        $order = $this->iModel->find($id);
        if($order->status == AgentOrderForm::STATUS_WATI_CHECK) {
            $order->status = AgentOrderForm::STATUS_WAIT_POST;
            $order->save();
        }
        return redirect()->route('staff.order.lists');
    }

    /**
     * 设置已支付
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function payed(Request $request, $id) {
        $order = $this->iModel->find($id);
        if($order->status == AgentOrderForm::STATUS_NOT_PAY) {
            $order->status = AgentOrderForm::STATUS_WAIT_POST;
            $order->save();
        }
        return redirect()->route('staff.order.lists');
    }


    /**
     * 设置未支付
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function notPay(Request $request, $id) {
        $order = $this->iModel->find($id);
        if($order->status == AgentOrderForm::STATUS_WATI_CHECK) {
            $order->status = AgentOrderForm::STATUS_NOT_PAY;
            $order->save();
        }
        return redirect()->route('staff.order.lists');
    }


    /**
     * 设置未支付
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(Request $request, $id) {
        $order = $this->iModel->find($id);
        if($order->status == AgentOrderForm::STATUS_NOT_PAY) {
            $order->status = AgentOrderForm::STATUS_CANCEL;
            $order->save();
        }
        return redirect()->route('staff.order.lists');
    }

    /**
     * 设置未支付
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Request $request, $id) {
        $order = $this->iModel->find($id);
        if($order->status == AgentOrderForm::STATUS_CANCEL) {
            $order->status = AgentOrderForm::STATUS_NOT_PAY;
            $order->save();
        }
        return redirect()->route('staff.order.lists');
    }

    public function export(Request $request) {
        //判断状态是否为货发货
        $data = $request->all();
        if(isset($data['status']) && $data['status'] == AgentOrderForm::STATUS_WAIT_POST) {
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
            $data = $query->select($this->field)->get();
            //打开excel
            // Create new PHPExcel object
            $objPHPExcel = new \PHPExcel();

// Add some data
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', '订单编号')
                ->setCellValue('B1', '收件人姓名（必填）')
                ->setCellValue('C1', '收件人手机（必填）')
                ->setCellValue('D1', '地址（必填）')
                ->setCellValue('E1', '产品（选填）')
                ->setCellValue('F1', '代理商名字（选填）')
                ->setCellValue('G1', '快递公司（必填）')
                ->setCellValue('H1', '快递单号（必填）');
// Miscellaneous glyphs, UTF-8
            foreach($data as $index => $d) {
                $goodsStr = '';
                foreach($d->orders as $order) {
                    $goodsStr .= $order->goods_name. 'x'.$order->goods_amount.';';
                }


                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.($index+2), $d->order_code)
                    ->setCellValue('B'.($index+2), $d->receiver_name)
                    ->setCellValue('C'.($index+2), $d->receiver_mobile)
                    ->setCellValue('D'.($index+2), $d->receiver_addr)
                    ->setCellValue('E'.($index+2), $goodsStr)
                    ->setCellValue('F'.($index+2), empty($d->submiter)? '': $d->submiter->username)
                    ->setCellValue('G'.($index+2), '')
                    ->setCellValue('H'.($index+2), '');
            }

            $objPHPExcel->setActiveSheetIndex(0);


            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            $time = date('Y-m-d H:i:s');
            header('Content-Disposition: attachment;filename="'.$time.'.xlsx"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');

            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0

            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
        }

    }

    public function import(Request $request) {
        $result = [
            'status' => false,
            'name' => '',
            'msg' => '导入失败',
        ];        if (!$request->hasFile('file')) {
            $result['msg'] = '导入文件为空';
            return response()->json($result, 422);
        }
        $file = $request->file('file');
        if (!$file->isValid()) {
            $result['msg'] = '文件导入出错';
            return response()->json($result, 422);
        }

        $path = $file->storeAs('file', uniqid() . '.' . $file->extension());

        if (!empty($path)) {
            //根据结果得到内容
            $data = [
                'status' => true,
                'name' => $path,
                'msg' => '',
            ];

            $objPHPExcel = \PHPExcel_IOFactory::load(public_path($path));
            $sheet = $objPHPExcel->getActiveSheet();
            $row = $sheet->getHighestRow();
            $data = [];
            for($i = 2; $i<=$row; $i++) {
                $id = $sheet->getCell('A'.$i)->getValue();
                $name = $sheet->getCell('G'.$i)->getValue();
                $code = $sheet->getCell('H'.$i)->getValue();
                $data[$id] = [
                    'post_company' => $name,
                    'post_code' => $code,
                    'status' => AgentOrderForm::STATUS_FINISHED,
                ];
            }
            //更新数据
            foreach($data as $id=> $d) {
                DB::table('agent_order_forms')->where('order_code', $id)->update($d);
            }
            return response()->json($data);
        }
        return response()->json([], 422);
    }
}