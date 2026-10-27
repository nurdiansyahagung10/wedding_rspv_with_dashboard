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
        $wishes = $this->model::where('has_answer', true)
            ->whereNotNull('wishes')->where('wishes', '!=', '')
            ->latest('updated_at')->limit(50)->get(['name', 'wishes']);
        return view('Guest.app', ['data' => $data, 'wishes' => $wishes]);
    }

    public function update(Request $request,$id){
        $data = $this->model::find($id);
        if($data == null){
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Data tamu tidak ditemukan'], 404);
            }
            abort(404);
        }
        if($request->has_answer_false){
            $data->has_answer = false;
        }else{
            $data->has_answer = true;
            $data->is_attending = $request->is_attending;
            $data->amount_of_guest = $request->amount_of_guest;
            $data->wishes = trim($request->wishes ?? '');
        }
        $data->save();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Konfirmasi berhasil disimpan',
                'data' => [
                    'id' => $data->id,
                    'name' => $data->name,
                    'has_answer' => (bool) $data->has_answer,
                    'is_attending' => (bool) ($data->is_attending === 'yes' || $data->is_attending === '1' || $data->is_attending === 1 || $data->is_attending === true),
                    'amount_of_guest' => (int) ($data->amount_of_guest ?? 1),
                    'is_private_cat' => (bool) $data->is_private_cat,
                    'wishes' => (string) ($data->wishes ?? ''),
                ],
            ]);
        }

        return redirect()->route('Guest.index', ['uuid' => $data->uuid]);
    }
}
