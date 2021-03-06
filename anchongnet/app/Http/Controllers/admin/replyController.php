<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Community_reply;

/**
*   该控制器包含了聊聊回复模块的操作
*/
class replyController extends Controller
{
    private $reply;
    public function __construct()
    {
        $this->reply=new Community_reply();
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
     * @param  $request('comid'聊聊ID,'name'名字,'content'内容,'headpic'头像,'chat'聊聊ID,'comname'评论人)
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->reply->comid=$request['comid'];
        $this->reply->name=$request['name'];
        $this->reply->content=$request['content'];
        $this->reply->headpic=$request['headpic'];
        $this->reply->chat_id=$request['chat'];
        $this->reply->comname=$request['comname'];
        $this->reply->save();
        return "回复成功";
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
     * @param  $request('','','','','')
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
