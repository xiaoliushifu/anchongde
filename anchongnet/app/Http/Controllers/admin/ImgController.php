<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Goods_img;

use OSS\OssClient;
use OSS\Core\OssException;

/**
*   该控制器包含了商品图片模块的操作
*/
class ImgController extends Controller
{
    private $img;
    private $good;
    private $accessKeyId;
    private $accessKeySecret ;
    private $endpoint;
    private $bucket;

    public function __construct()
    {
        $this->img=new Goods_img();
        $this->accessKeyId="HJjYLnySPG4TBdFp";
        $this->accessKeySecret="Ifv0SNWwch5sgFcrM1bDthqyy4BmOa";
        $this->endpoint="oss-cn-hangzhou.aliyuncs.com";
        $this->bucket="anchongres";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request('file'文件对象)
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fileType=$_FILES['file']['type'];
        $filePath = $request['file'];
        switch($request->imgtype){
            case 1:
                $dir="goods/img/detail/";
                break;
            case 2:
                $dir="goods/img/param/";
                break;
            case 3:
                $dir="goods/img/data/";
                break;
            case 4:
                $dir="information/";
                break;
        }
        //设置上传到阿里云oss的对象的键名
        switch ($fileType) {
            case "image/png":
                $object=$dir.time().rand(100000,999999).".png";
                break;
            case "image/jpeg":
                $object=$dir.time().rand(100000,999999).".jpg";
                break;
            case "image/jpg":
                $object=$dir.time().rand(100000,999999).".jpg";
                break;
            case "image/gif":
                $object=$dir.time().rand(100000,999999).".gif";
                break;
            default:
                $object=$dir.time().rand(100000,999999).".jpg";
        }

        try {
            //实例化一个ossClient对象
            $ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
            //上传文件
            $ossClient->uploadFile($this->bucket, $object, $filePath);
            //获取到上传文件的路径
            $signedUrl = $ossClient->signUrl($this->bucket, $object);
            $pos = strpos($signedUrl, "?");
            $urls = substr($signedUrl, 0, $pos);
            $url = str_replace('.oss-','.img-',$urls);

            $message="上传成功";
            $isSuccess=true;
        }catch (OssException $e) {
            $message="上传失败，请稍后再试";
            $isSuccess=false;
            $url="";
        }
        return response()->json(['message' => $message, 'isSuccess' => $isSuccess,'url'=>$url]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $request('file'文件对象)
     * @param  int  $id图片ID
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fileType=$_FILES['file']['type'];
        $filePath = $request['file'];
        switch($request->imgtype){
            case 1:
                $dir="goods/img/detail/";
                break;
            case 2:
                $dir="goods/img/param/";
                break;
            case 3:
                $dir="goods/img/data/";
                break;
        }
        //设置上传到阿里云oss的对象的键名
        switch ($fileType){
            case "image/png":
                $object=$dir.time().rand(100000,999999).".png";
                break;
            case "image/jpeg":
                $object=$dir.time().rand(100000,999999).".jpg";
                break;
            case "image/jpg":
                $object=$dir.time().rand(100000,999999).".jpg";
                break;
            case "image/gif":
                $object=$dir.time().rand(100000,999999).".gif";
                break;
            default:
                $object=$dir.time().rand(100000,999999).".jpg";
        }

        try {
            //实例化一个ossClient对象
            $ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
            //上传文件
            $ossClient->uploadFile($this->bucket, $object, $filePath);
            //获取到上传文件的路径
            $signedUrl = $ossClient->signUrl($this->bucket, $object);
            $pos = strpos($signedUrl, "?");
            $urls = substr($signedUrl, 0, $pos);
            $url = str_replace('.oss-','.img-',$urls);

            //更新数据库
            $data=$this->img->find($id);
            $data->url=$url;
            $data->save();

            $message="更新成功";
            $isSuccess=true;
        }catch (OssException $e) {
            $message="更新失败，请稍后再试";
            $isSuccess=false;
        }
        return response()->json(['message' => $message, 'isSuccess' => $isSuccess]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id货品图片ID
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data=$this->img->find($id);
        $data->delete();
        return "删除成功";
    }

    /**
     * 获取同一个商品的所有图片的方法
     *
     * @param  $request('gid'货品ID)
     * @return \Illuminate\Http\Response
     */
    public function getGoodImg(Request $request)
    {
        $datas=$this->img->Gid($request->gid)->get();
        return $datas;
    }
}
