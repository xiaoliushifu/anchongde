<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Request as Requester;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\GoodCat;

class goodCateController extends Controller
{
    private $cat;
    /*
     * 构造方法
     * */
    public function __construct()
    {
        $this->cat=new GoodCat();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyName=Requester::input('keyName');
        if($keyName==""){
            $datas=$this->cat->paginate(8);
        }else{
            $datas = GoodCat::Name($keyName)->paginate(8);
        }
        $args=array("keyName"=>$keyName);
        return view('admin/cate/index',array("datacol"=>compact("args","datas")));
    }

    /*
     * 获取某个二级分类的所有兄弟分类的方法
     * 即获取同一个一级分类下的所有二级分类的方法
     * */
    public function getSiblings(Request $request){
        $cid=$request['cid'];
        $pid=$this->cat->find($cid)->parent_id;
        $datas=$this->cat->Level($pid)->get();
        return $datas;
    }

    /*
     * 获取指定一级或二级分类的方法
     * */
    public function getLevel(Request $request){
        $pid=$request['pid'];
        $datas = GoodCat::Level($pid)->get();
        return $datas;
    }

    /*
     * 获取所有二级分类的方法
     * */
    public function getLevel2(){
        $datas = GoodCat::Level2()->get();
        return $datas;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.cate.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->cat->cat_name=$request['catname'];
        $this->cat->keyword=$request['keyword'];
        $this->cat->cat_desc=$request['description'];
        $this->cat->is_show=$request['ishow'];
        $this->cat->parent_id=$request['parent'];
        $result=$this->cat->save();
        if($result){
            return redirect()->back();
        }else{
            dd("修改失败，请返回重试");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=$this->cat->find($id);
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data=$this->cat->find($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data=$this->cat->find($id);
        $data->cat_name=$request['catname'];
        $data->keyword=$request['keyword'];
        $data->cat_desc=$request['description'];
        $data->is_show=$request['ishow'];
        $data->parent_id=$request['parent'];
        $result=$data->save();
        if($result){
            return redirect()->back();
        }else{
            dd("修改失败，请返回重试");
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
        $data=$this->cat->find($id);
        $result=$data->delete();
        if($result){
            return "删除成功";
        }else{
            return "删除失败";
        }
    }
}