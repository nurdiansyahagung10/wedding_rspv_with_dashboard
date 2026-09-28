<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    private $model;
    public function __construct(){
        $this->model = new Guest();
    }

    public function index($uuid){
        $data  =$this->model::where('uuid', $uuid)->first();
        if($data == null){
            abort(404);
        }
        return view('Guest.app', ['data' => $data]);
    }

    public function update(Request $request,$id){
        $data = $this->model::find($id);
        if($data == null){
            abort(404);
        }
        if($request->has_answer_false){
        $data->has_answer = false;

        }else{
            $data->has_answer = true;
            $data->is_attending = $request->is_attending;
            $data->amount_of_guest = $request->amount_of_guest;
            $data->wishes = trim($request->wishes);
        }
        $data->save();
        return redirect()->route('Guest.index', ['uuid' => $data->uuid]);
    }
}
