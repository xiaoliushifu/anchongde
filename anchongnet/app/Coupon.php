<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'anchong_coupon';
    protected $guard='acid';
    //不允许被赋值
    protected $guarded = [];
    public  $timestamps=false;

    /*
    *   查询
    */
    public function quer($field,$quer_data)
    {
        return $this->select($field)->where($quer_data)->get();
    }

    /*
     * 查询构造器
     */
    public function scopeCoupon($query)
    {
        return $query;
    }

    /*
    *   判断是否有数据
    */
    public function countquer($type)
    {
        return $this->whereRaw($type)->count();
    }
}