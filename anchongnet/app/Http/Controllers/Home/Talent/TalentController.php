<?php

namespace App\Http\Controllers\Home\Talent;

use App\Business;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TalentController extends Controller
{
    public function index()
    {

        $data = Business::where('type', 3)->orderBy('created_at', 'desc')->paginate(15);

        return view('home.talent.talentlist', compact('data'));
 }

    public function create()
    {
        return view('/home.release.releasetalent');
    }

    public function store()
    {

    }

    public function show($bid)
    {
                $data = Business::find($bid);
        $data->content = str_replace("\n", "<br>", $data->content);
        return view('home.talent.talentmain', compact('data'));

 }




}