<?php

namespace App\Http\Controllers\Api\Pay;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Omnipay;
use Input;
use Log;
use EasyWeChat\Payment\Order;
use QrCode;

/*
*   支付控制器
*/
class PayController extends Controller
{
    /*
    *   该方法是支付宝的支付接口
    */
    public function alipay()
    {
        // 创建支付单。
        $alipay = app('alipay.web');
        $alipay->setOutTradeNo('9486981467365887');
        $alipay->setTotalFee('10');
        $alipay->setSubject('安虫测试付2款单');
        $alipay->setBody('goods_description');

        //$alipay->setQrPayMode('4'); //该设置为可选，添加该参数设置，支持二维码支付。

        // 跳转到支付页面。
        return redirect()->to($alipay->getPayLink());
    }

    /*
    *   该方法是微信的支付接口
    */
    public function wxpay()
    {
        $wechat = app('wechat');
        $attributes = [
            'trade_type'       => 'NATIVE', // JSAPI，NATIVE，APP...
            'body'             => 'iPad mini 16G 白色',
            'detail'           => 'iPad mini 16G 白色',
            'out_trade_no'     => '2217752501201407033233368017',
            'total_fee'        => 2,
            'notify_url'       => 'http://xxx.com/order-notify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            // ...
        ];
        $order = new Order($attributes);
        $payment=$wechat->payment;
        $result = $payment->prepare($order);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
            $prepayId = $result->prepay_id;
        }
        var_dump($result);
        return QrCode::generate($result->code_url);
    }

    /*
    *   该方法是微信的支付接口
    */
    public function wxnotify()
    {
        $wechat = app('wechat');
        $attributes = [
            'trade_type'       => 'NATIVE', // JSAPI，NATIVE，APP...
            'body'             => 'iPad mini 16G 白色',
            'detail'           => 'iPad mini 16G 白色',
            'out_trade_no'     => '2217752501201407033233368017',
            'total_fee'        => 2,
            'notify_url'       => 'http://xxx.com/order-notify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            // ...
        ];
        $order = new Order($attributes);
        $payment=$wechat->payment;
        $result = $payment->prepare($order);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
            $prepayId = $result->prepay_id;
        }
        var_dump($result);
        return QrCode::generate($result->code_url);
    }

    /*
    *   异步通知
    */
   public function webnotify()
   {
       // 验证请求。
       if (! app('alipay.web')->verify()) {
           Log::notice('Alipay notify post data verification fail.', [
               'data' => Request::instance()->getContent()
           ]);
           return 'fail';
       }

       // 判断通知类型。
       switch (Input::get('trade_status')) {
           case 'TRADE_SUCCESS':
                //开启事务处理
                DB::beginTransaction();
                $paynum=Input::get('out_trade_no');
                //创建ORM模型
                $order=new \App\Order();
                $pay=new \App\Pay();
                //判断总价防止app攻击
                $total_price=0;
                $order_id_arr=$pay->quer(['order_id','total_price'],'paynum ='.$paynum)->toArray();
                foreach ($order_id_arr as $order_id) {
                    //对总价进行累加
                    $total_price +=$order_id['total_price'];
                    //进行订单操作
                    $result=$order->orderupdate($order_id['order_id'],['state' => 2]);
                    if(!$result){
                        //再次执行
                        $result=$order->orderupdate($order_id['order_id'],['state' => 2]);
                        if(!$result){
                            //假如失败就回滚
                            DB::rollback();
                            return 'fail';
                        }
                    }
                }
                if($total_price == Input::get('total_fee')){
                        //假如成功就提交
                        DB::commit();
                        return 'success';
                }else{
                    //假如失败就回滚
                    DB::rollback();
                    return 'fail';
                }
                break;
           case 'TRADE_FINISHED':
               // TODO: 支付成功，取得订单号进行其它相关操作。
               Log::debug('Alipay notify post data verification success.', [
                   'out_trade_no' => Input::get('out_trade_no'),
                   'trade_no' => Input::get('trade_no')
               ]);
               break;
       }
   }

   /*
   *   异步通知
   */
  public function mobilenotify(Request $request)
  {
      //获得app传过来的参数
      $data=$request::all();
      // 验证请求。
    //   if (! app('alipay.mobile')->verify()) {
    //
    //       return 'fail1';
    //   }

      // 判断通知类型。
      switch ($data['trade_status']) {
          case 'TRADE_SUCCESS':
               //开启事务处理
               DB::beginTransaction();
               $paynum=$data['out_trade_no'];
               //创建ORM模型
               $order=new \App\Order();
               $pay=new \App\Pay();
               //判断总价防止app攻击
               $total_price=0;
               $order_id_arr=$pay->quer(['order_id','total_price'],'paynum ='.$paynum)->toArray();
               foreach ($order_id_arr as $order_id) {
                   //对总价进行累加
                   $total_price +=$order_id['total_price'];
                   //进行订单操作
                   $result=$order->orderupdate($order_id['order_id'],['state' => 2]);
                   if(!$result){
                       //再次执行
                       $result=$order->orderupdate($order_id['order_id'],['state' => 2]);
                       if(!$result){
                           //假如失败就回滚
                           DB::rollback();
                           return 'fail';
                       }
                   }
               }

            //假如价格比对成功就提交
            if($total_price == $data['total_fee']){
                DB::commit();
                return 'success';
            }else{
                //假如失败就回滚
                DB::rollback();
                return 'fail';
            }
               break;
          case 'TRADE_FINISHED':
              // TODO: 支付成功，取得订单号进行其它相关操作。
              //开启事务处理
              DB::beginTransaction();
              $paynum=$data['out_trade_no'];
              //创建ORM模型
              $order=new \App\Order();
              $pay=new \App\Pay();
              //判断总价防止app攻击
              $total_price=0;
              $order_id_arr=$pay->quer(['order_id','total_price'],'paynum ='.$paynum)->toArray();
              foreach ($order_id_arr as $order_id) {
                  //对总价进行累加
                  $total_price +=$order_id['total_price'];
                  //进行订单操作
                  $result=$order->orderupdate($order_id['order_id'],['state' => 2]);
                  if(!$result){
                      //再次执行
                      $result=$order->orderupdate($order_id['order_id'],['state' => 2]);
                      if(!$result){
                          //假如失败就回滚
                          DB::rollback();
                          return 'fail';
                      }
                  }
              }

           //假如价格比对成功就提交
           if($total_price == $data['total_fee']){
               DB::commit();
               return 'success';
           }else{
               //假如失败就回滚
               DB::rollback();
               return 'fail';
           }
              break;
      }
  }

   /*
    *   同步通知
    */
   public function webreturn()
   {
       // 验证请求。
       if (! app('alipay.web')->verify()) {
           Log::notice('Alipay return query data verification fail.', [
               'data' => Request::getQueryString()
           ]);
           return view('test');
       }

       // 判断通知类型。
       switch (Input::get('trade_status')) {
           case 'TRADE_SUCCESS':
           case 'TRADE_FINISHED':
               // TODO: 支付成功，取得订单号进行其它相关操作。
               Log::debug('Alipay notify get data verification success.', [
                   'out_trade_no' => Input::get('out_trade_no'),
                   'trade_no' => Input::get('trade_no')
               ]);
               break;
       }

       return view('test');
   }
}
