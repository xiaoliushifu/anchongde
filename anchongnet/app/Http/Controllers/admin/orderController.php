<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;

use App\Http\Controllers\Controller;
use App\Order;
use App\Orderinfo;
use DB;
use Gate;
use Auth;
use App\Exp;
use App\Shop;
use App\Goods_logistics;

/**
*   该控制器包含了订单模块的操作
*/
class orderController extends Controller
{
    private $order;
    private $orderinfo;
    private $uid;
    private $sid;
    private $gl;
    public function __construct()
    {
        $this->order=new Order();
        $this->orderinfo=new Orderinfo();

        //通过Auth获取当前登录用户的id
        $this->uid=Auth::user()['users_id'];
        if (!is_null($this->uid)){//通过用户获取商铺id
            $this->sid=Shop::Uid($this->uid)->sid;
        }
    }

    /**
	 * 后台订单管理列表
     *
     * @param  input('KEYNUM'区分查询数据的关键字)
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kn=Requester::input('kn');
        $ks=Requester::input('state');
        if ($kn) {
            $datas = Order::num($kn,$this->sid)->orderBy("order_id","desc")->paginate(8);
        } elseif ($ks) {
            $datas=$this->order->where("sid","=",$this->sid)->where('state',$ks)->orderBy("order_id","desc")->paginate(8);
        } else {
            $datas=$this->order->where("sid","=",$this->sid)->orderBy("order_id","desc")->paginate(8);
        }
        $args=array("state"=>$ks);
        return view('admin/order/index',array("datacol"=>compact("args","datas")));
    }

    /**
     * 显示后台添加订单页面
     *
     * @param  $request('','','','','')
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request('','','','','')
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $request('status'订单状态)
     * @param  int  $id订单ID
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data=$this->order->find($id);
        if($request->iSend==true){
            $data->state=$request->status;
            $data->save();
            return "提交成功";
        }else{

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    /**
     * 审核订单，ajax调用
     *
     * @param  $request('isPass'是否退货,'num'订单标号,'gid'货品ID,'oid'订单ID)
     * @return \Illuminate\Http\Response
     */
    public function checkorder(Request $request)
    {
        //获取订单ID
        $id=$request->oid;
        //得到操作订单数据的句柄
        $data=$this->order->find($id);
        //开启事务处理
        DB::beginTransaction();
        //判断是否通过退货
        if ($request->isPass==="pass") {
            //若通过退货则改变订单状态并将商品数量还原
            $datasarr=$this->orderinfo->where('order_num','=',$request->num)->get()->toArray();
            //遍历得到的结果
            foreach ($datasarr as $datas) {
                //更改货品列表的数量
                DB::table('anchong_goods_specifications')->where('gid','=',$datas['gid'])->increment('goods_num',$datas['goods_num']);
                //更改区域表的数量
                DB::table('anchong_goods_stock')->where('gid','=',$datas['gid'])->increment('region_num',$datas['goods_num']);
            }
            //改变订单状态为已退款
            $data->state=5;
        } else {
            //改变订单状态为代发货
            $data->state=3;
        }
        $data->save();
        //假如成功就提交
        DB::commit();
        return "操作成功";
    }

    /**
     * 订单发货的方法
     * 由订单列表页，点击"发货",选择完发货方式后执行
     *
     * @param  $request('orderid'订单ID,'ship'行为参数,'lognum'物流单号,'logistics'企业)
     * @return \Illuminate\Http\Response
     */
    public function orderShip(Request $req)
    {
        //权限判定
        if (Gate::denies('order-ship')) {
            return back();
        }
        $carrier=['0','hand'];
        //物流发货方式
        if ($req['ship'] == "wl") {
           //获得订单数据，准备聚合接口的请求参数
           $orderpa = $this->order->find($req['orderid']);
           $orderpa['receiver_province_name'] = '北京';
           $orderpa['receiver_city_name'] = '北京市';
           $orderpa['receiver_district_name'] = '昌平区';
           $orderpa['send_start_time'] = date('Y-m-d H:i:s',time()+3600);//通知快递员10分钟后取件
           $orderpa['send_end_time'] = date('Y-m-d H:i:s',time()+7200);//半小时后
           $orderpa['phone'] = '18600818638';
           $orderpa['address'] = '北京市昌平区回龙腾二街2号院';
           $exp = new Exp();
           //向指定物流公司下单
           $carrier = explode('|',$req['logistics']);
           $res = $exp->sendOrder($orderpa,$carrier[0]);
            //记录一次下单
            \Log::info(print_r($res,true),['result_juheSend:'.$orderpa['order_num']]);
            if ($res['error_code'] != '0') {//正常下单
                return $res['reason'];
            }
        }
        //记录一次下单
        $this->gl=new Goods_logistics();
        $this->gl->logisticsnum=$req['onum'];
        $this->gl->order_id=$req['orderid'];
        $this->gl->com_code=$carrier[0];//物流公司编号
        $this->gl->company=$carrier[1];
        $this->gl->save();
        
        //改状态为'3待收货'
        $data=$this->order->find($req['orderid']);
        $data->state=3;
        $data->save();
        DB::commit();
        $this->propleinfo($data->users_id,'订单发货通知','您订单编号为'.$data->order_num.'的订单已发货，感谢您对安虫平台的支持！');
        return 0;
    }


    /*
     * 由聚合回调，用于安虫下单后，接收其有关订单状态的信息
     * */
    public function ostatus(Request $req)
    {
        
//         $black = ['121.43.160.158','123.150.107.239','124.239.251.119','127.0.0.1'];
//         if (!in_array($req->ip(),$black)){
//             return '非法请求';
//         }
        $header = getallheaders();
        $body = file_get_contents('php://input');
        \Log::info("clientIP:".$req->ip().print_r($header,true).PHP_EOL.$body,['订单推送信息']);
        $body = json_decode($body,true);
        if ($this->derror($body)) {
            return 'error';
        }
        $res=$body['orders'][0];
        DB::table('anchong_ostatus')->insert(['logisticsnum'=>$res['order_no'],'company'=>$res['carrier_code'],'status'=>$res['status'],'time'=>$res['time'],'content'=>$res['content']]);
        return 'success';
    }

    /*
     * 由聚合回调，用于安虫下单后，接收其有关物流状态的信息
     * */
    public function lstatus(Request $req)
    {
        
//         $black = ['121.43.160.158','123.150.107.239','124.239.251.119','127.0.0.1'];
//         if (!in_array($req->ip(),$black)){
//             return '非法请求';
//         }
        $header = getallheaders();
        $body = file_get_contents('php://input');
        \Log::info("clientIP:".$req->ip().print_r($header,true).PHP_EOL.$body,['物流推送信息']);
        $body = json_decode($body,true);
        if ($this->derror($body)) {
            return 'error';
        }
        $res=$body['orders'][0]['order'];
        $data=$body['orders'][0]['data'];
        DB::table('anchong_lstatus')->insert(['logisticsnum'=>$res['order_no'],'company'=>$res['carrier_code'],'bill_code'=>$res['bill_code'],'status'=>$res['status'],'data'=>serialize($data)]);
        //物流发货方式
        return 'success';
    }

    /*
     * 取消物流订单的方法
     * */
    public function orderCancel(Request $req)
    {
        //权限判定
        if (Gate::denies('order-ship')) {
            return back();
        }
        DB::beginTransaction();
        //下单表
        $this->gl=Goods_logistics::where('order_id',$req['oid'])->where('ship',1)->first();
        $this->gl->ship=0;
        $this->gl->save();
        if ($this->gl->com_code) {
            $exp = new Exp();
            $res = $exp->cancelOrder($req,$this->gl->com_code);
            //记录一次撤单
            \Log::info(print_r($res,true),['juheCancel:'.$req['onum']]);
            if ($res['error_code']!='0') {//正常撤单
                return $res['reason'];
            }
        }

        //订单表更新
        $data=$this->order->find($req['oid']);
        //改回状态为'2待发货'
        $data->state=2;
        $data->save();
        DB::commit();
        $this->propleinfo($data->users_id,'发货取消通知','您订单编号为'.$data->order_num.'的订单已停止发货，感谢您对安虫平台的支持！');
        return '撤单成功';
    }

    /**
    *    该方法提供了订单的推送服务
    *
    * @param  用户ID  $users_id
    * @param  标题    $title
    * @param  信息    $message
    * @return \Illuminate\Http\Response
    */
    private function propleinfo($users_id,$title,$Message)
    {
        //处理成功给用户和商户推送消息
        try{
            //创建ORM模型
            $users=new \App\Users();
            $this->propel=new \App\Http\Controllers\admin\Propel\PropelmesgController();
            //推送消息
            $this->propel->apppropel($users->find($users_id)->phone,$title,$Message);
            DB::table('anchong_feedback_reply')->insertGetId(
                [
                    'title' => $title,
                    'content' => $Message,
                    'users_id' => $users_id,
                ]
             );
             return true;
        }catch (\Exception $e) {
            // 返回处理完成
            return true;
        }
    }
    
    /**
     * 用于解析聚合回调的json信息
     * @param unknown $data
     */
    private function derror($data)
    {
        $res = '';
        if (!$data) {
            switch (json_last_error()) {
                case JSON_ERROR_NONE:
                    $res =  ' - No errors';
                    break;
                case JSON_ERROR_DEPTH:
                    $res =  ' - Maximum stack depth exceeded';
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    $res =  ' - Underflow or the modes mismatch';
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    $res =  ' - Unexpected control character found';
                    break;
                case JSON_ERROR_SYNTAX:
                    $res =  ' - Syntax error, malformed JSON';
                    break;
                case JSON_ERROR_UTF8:
                    $res =  ' - Malformed UTF-8 characters, possibly incorrectly encoded';
                    break;
                default:
                    $res =  ' - Unknown error';
                    break;
            }
            \Log::info($res,['json_error']);
        }
        return $res;
    }
}
