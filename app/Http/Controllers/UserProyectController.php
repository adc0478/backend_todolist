<?php

namespace App\Http\Controllers;

use App\Models\user_has_proyect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserProyectController extends Controller
{
    //
    public $output = [
        'status' => false,
        'data' => [],
        'info' => "",
        'error' =>""
    ];
    public function store(Request $request):object{
        $validate = Validator::make($request->all(),[
            'user_id' => "required|int",
            'proyect_idproyect' => "required",
            'type' => "required|string"
        ]);
        if ($validate->fails()){
            $this->output['error'] = "No se han pasado adecuadamente los id's vinculantes";
        }else{
            $model_user_proyect = new user_has_proyect();
            $response = $model_user_proyect->register($request['proyect_idproyect'], $request['user_id'], $request['type']);
            if (!$response['status']){
                $this->output['error'] = "No se pudo registrar la vinculaciòn";
            }else{
                $this->output['status'] = true;
                $this->output['data'] = $this->get_data($request['proyect_idproyect']);
            }
        }

        return response()->json($this->output);
    }
    public function modify(Request $request):object{
        $validate = Validator::make($request->all(),[
            'id_user_proyect' => "required",
            'proyect_idproyect' => "required"
        ]);
        if ($request['type'] == Null){
            $request['type'] = "-";
        }
        if ($validate->fails()){
            $this->output['error'] = "No se han pasado adecuadamente los id's vinculantes";
        }else{
            $model_user_proyect = new user_has_proyect();
            $response = $model_user_proyect->modify($request['id_user_proyect'],$request['type']);
            if (!$response['status']){
                $this->output['error'] = "No se pudo registrar la vinculaciòn";
            }else{
                $this->output['status'] = true;
                $this->output['data'] = $this->get_data($request['proyect_idproyect']);
            }
        }

        return response()->json($this->output);

    }
    public function remove_relation(Request $request):object{
        $validate = Validator::make($request->all(),[
            'id' => "required|int"
        ]);
        if ($validate->fails()){
            $this->output['error'] = "Debe ingresar un ID valido";
        }else {
            $model_user_proyect = new user_has_proyect();
            $response = $model_user_proyect->remove($request['id']);
            if (!$response['status']){
                $this->output["error"] = "Error al quitar la vinculacion";
            }else {
                $this->output = $this->get_data($request['proyect_idproyect_idproyect']);
                $this->output["status"] = true;
            }
        }


        return response()->json($this->output);
    }
    public function get_relation_user_proyect(Request $request):object{
        $validate = Validator::make($request->all(),[
            'idproyect' => 'required'
        ]);
        if ($validate->fails()){
            $this->output['status'] = false;
            $this->output['error'] = "Parametros invalidos";
        }else{
            $this->output['status'] = true;
            $this->output['data'] = $this->get_data($request['idproyect']) ;
        }
        return response()->json($this->output);
    }
    public function get_data(string $idproyect):array{
        $model = new user_has_proyect();
        $data = $model->search_relation_user_proyect($idproyect);
        return $data['data'];
    }
}
