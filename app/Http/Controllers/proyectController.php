<?php

namespace App\Http\Controllers;
use App\Models\user_has_proyect;
use Exception;
use App\Models\proyect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class proyectController extends Controller
{
    //registrar
    //editar
    //borrar
    //listar
    public array $output = [
        'status' => false,
        'data' => [],
        'error' => ""
    ];
    public function store (Request $request):object{
       $validate = Validator::make($request->all(),[
            "name" => 'required'
        ]);
        if ($validate->fails()){
            $this->output['error'] = "Por favor ingrese un nombre de proyecto";
        }else {
            DB::beginTransaction();
            try {
                $model = new proyect();
                $response = $model->create($request['name']);
                $id_user = auth()->user();
                $model_user_proyect = new user_has_proyect();
                $response_user_proyect = $model_user_proyect->register($response['data']['idproyect'], $id_user['id'], "adm");

                $this->output['data'] = $this->list_proyect();
                $this->output['status'] =true;
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                if (!$response['status']){
                    $this->output['error'] = $e; //$response['error'];
                }else{
                    $this->output['error'] = $e; //$response_user_proyect['error'];
                }
            }


        }
        return response()->json($this->output);
    }
    public function remove_proyect(Request $request):object{
        $validate = Validator::make($request->all(),[
            "proyect_idproyect" => "required"
        ]);
        if ($validate->fails()){
            $this->output['error'] = "No ha ingresado un id de proyecto valido";
        }else{
            try {
                $model = new proyect();
                $response = $model->remove_proyect($request->proyect_idproyect);
                $this->output['data'] = $this->list_proyect();
                $this->output['status'] = true;
            } catch (Exception $e) {
                $this->output['error'] = $response['error'];
            }
        }
        return response()->json($this->output);
    }
    private function list_proyect ():object{
        $proyect = new proyect();
        return $proyect->search_proyect_by_user(auth()->user()->id);
    }
    public function list_custon_proyect():object{
        $this->output['data'] = $this->list_proyect();
        return response()->json($this->output);
    }
}
