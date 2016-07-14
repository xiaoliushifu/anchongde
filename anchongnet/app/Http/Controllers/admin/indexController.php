<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session,Redirect,Request,Hash,Auth;
use DB;
use App\Shop;
use App\Users_login;

class indexController extends Controller
{

     /*
     *  后台首页
     */
    public function index()
    {
        //通过Auth获取当前登录用户的id
        $uid=Auth::user()['users_id'];
        //通过用户获取商铺id
        $sid=Shop::Uid($uid)->sid;
        //通过用户id获取上次登录时间
        $lasttime=Users_login::Uid($uid)->last_login;
        //转换时间
        $datetime=date('Y-m-d H:i:s',$lasttime);
        //定义变量
        $neworder=0;
        $newuser=0;
        $newshop=0;
        $newauth=0;
        //创建ORM模型
        $order=new \App\Order();
        $users=new \App\Users();
        $shop=new \App\Shop();
        $auth=new \App\Auth();
        //查询相比于上次登录新增的订单数目
        $ordernum=$order->ordercount('created_at > "'.$datetime.'" and sid ='.$sid);
        //查询新增的用户人数
        $newuser=$users->usercount('ctime >'.$lasttime);
        $newshop=$shop->shopcount('created_at > '.$lasttime);
        $newauth=$auth->authcount('created_at > "'.$datetime.'"');
        return view('admin.index',['username' => Auth::user()['username'],"neworder"=>$neworder,'newuser'=>$newuser,'newshop'=>$newshop,'newauth'=>$newauth,'last_time'=>$datetime]);
    }

    /*
    *  后台首页
    */
   public function zhuce()
   {
       return view('welcome');
   }

    /*
    *   验证登陆
    */
    public function checklogin(Request $request)
    {
        $data=$request::all();
        //判断验证码是否正确
        if($data['captchapic'] == Session::get('adminmilkcaptcha')){
            //判断用户名密码是否正确
            if (Auth::attempt(['username' => $data['username'], 'password' => $data['password']])){
                $users=new \App\Users();
                $rank=$users->quer('users_rank',['users_id'=>Auth::user()['users_id']])->toArray();
                //判断会员的权限是否是管理员
                if($rank[0]['users_rank'] == 3 || $rank[0]['users_rank']==2){
                    //创建orm
                    $users_login=new \App\Users_login();
                    $users_login->addToken(['last_login'=>time()],Auth::user()['users_id']);
                    return Redirect::intended('/');
                }else{
                    //假如会员权限不够就清除登录状态并退出
                    Auth::logout();
                    return Redirect::back();
                }
            }else{
                return Redirect::back()->withInput()->with('loginmes','账号或密码错误!');
            }
        }else{
            return Redirect::back()->withInput()->with('admincaptcha','请填写正确的验证码!');
        }
    }

    /*
    *   登出
    */
    public function logout()
    {
        //清除登录状态
        Auth::logout();
        return Redirect::intended('/');
    }

    /*
    *   注册
    */
    public function userregister(Request $request)
    {
        //开启事务处理
        DB::beginTransaction();
        $data=$request::all();
        //清除登录状态
        $users_login=new \App\Users_login();
        $users=new \App\Users();
        $users_data=[
            'phone' => $data['username'],
            'ctime' => time(),
        ];
        $usersid=$users->add($users_data);
        $users_login_data=[
            'users_id' => $usersid,
            'password' => Hash::make($data['password']),
            'username' => $data['username'],
            'token' => md5($data['username']),
            'user_rank' => 2,
        ];
        $result=$users_login->add($users_login_data);
        if($result){
            //假如成功就提交
            DB::commit();
            return '注册成功';
        }else{
            //假如失败就回滚
            DB::rollback();
            return '注册失败';
        }
    }
}
