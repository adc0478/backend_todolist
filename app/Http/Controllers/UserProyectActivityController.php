<?php

namespace App\Http\Controllers;

use App\Models\UserProyectActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserProyectActivityController extends Controller
{
    public $response = [
        'error'=>"",
        'list_user'=>[],
        'list_user_relation' =>[],
        'status' => false
    ];
    public function set_values(Request $request):Array{
        $validate = Validator::make($request,
            [
                'idactivity' =>'required',
                'idproyect' => 'required'
            ]
         );
        if ($validate.fails()){
            return ['status' => false];
        }
       return [
               'iduser'=>$request['iduser'],
               'idproyect' =>$request['idproyect'],
               'idactivity' =>$request['idactivity'],
               'status' =>true
            ];
    }
    public function set_model():Object{
        return new UserProyectActivity();
    }
    public function store(Request $request):Object{
        $data_validated = $this->set_values($request);
        if ($data_validated['status']){
            $model = new UserProyectActivity();
            $data_response = $model->store($data_validated);
        }
        return response()->json($this->response);
    }
    public function delete_relation(Request $request):Object{
        $data_validated = $this->set_values($request);
        if ($data_validated['status']){
            $model = new UserProyectActivity();

        }
        return response()->json($this->response);
    }
    public function list_relation(Request $request):Object{
        $data_validated = $this->set_values($request);
        if ($data_validated['status']){
            $model = new UserProyectActivity();

        }
        return response()->json($this->response);
    }
}
