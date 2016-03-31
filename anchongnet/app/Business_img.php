<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Redirect;
/*
*   该模型是操作用户登录表的模块
*/
class Business_img extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anchong_business_img';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     //不允许被赋值
    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public  $timestamps=false;

    /*
    *   该方法是添加发布信息带的图片
    */
    public function add($data)
    {
        //将数据存入登录表
        $this->fill($data);
        if($this->save()){
            return true;
        }else{
            //因为这个是多表插入，为了防止意外，在第一个用户表插入成功后第二个表插入失败时，会去删除第一个表中已插入的数据来确保数据的正确性
            $business=new \App\Business();
            if($business->del($data['id'])){
                return false;
            }else{
                return false;
            }
        }
    }
}
