<?php

namespace App\Http\Controllers;

use App\Models\activity;
use App\Models\task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class taskController extends Controller
{
    // insertar
    // modificar
    // borrar
    public $output = [
        "status" =>false,
        "data" => [],
        "info" => "",
        "error" => ""
    ];

    public function store(Request $request):object{
        $validate = Validator::make($request->all(),[
            'name' => "required",
            'proyect_idproyect' => "required|int"
        ]);
        if ($validate->fails()){
            $this->output['error']  = "Verifique los datos suministrados";
        }else {
           $task = new task();
            $response = $task->insert($request->name, $request->proyect_idproyect);
            $this->output['error'] = $response['error'];
            $this->output['status'] = $response['status'];
            $this->output['data'] = $this->get_data("",$request->proyect_idproyect);
        }
        return response()->json($this->output);
    }
    public function remove(Request $request):object{
        $validate = Validator::make($request->all(),[
            'idtask' => "required|int"
        ]);
        if ($validate->fails()){
            $this->output['error']  = "Verifique los datos suministrados";
        }else {
           $task = new task();
            $response = $task->remove($request->idtask);
            $this->output['error'] = $response['error'];
            $this->output['status'] = $response['status'];
            $this->output['data'] = $this->get_data("",$request['proyect_idproyect']) ;
        }
        return response()->json($this->output);
    }
    public function modify(Request $request):object{
        $validate = Validator::make($request->all(),[
            'name' => "required",
            'proyect_idproyect' => "required|int",
            'idtask' => "required|int",
        ]);
        if ($validate->fails()){
            $this->output['error']  = "Verifique los datos suministrados";
        }else {
            $task = new task();
            $response = $task->modify($request->name, $request->proyect_idproyect, $request->idtask);
            $this->output['error'] = $response['error'];
            $this->output['status'] = $response['status'];
            $this->output['data'] = $this->get_data("",$request['proyect_idproyect']) ;
        }
        return response()->json($this->output);
    }
    public function get_task(Request $request):object{
        $this->output['data'] = $this->get_data("",$request['idproyect']) ;
        return response()->json($this->output);
    }
    public function get_data(string $idtask,string $idproyect){
        $task_model = new task();
        $activity_model = new activity();
        $activity = $activity_model->list_activity_by_idproyect($idproyect);
        $data = $task_model->get_model($idtask,$idproyect);
        for ($i = 0; $i < count($data['data']); $i++) {
           $data['data'][$i]['acc'] = 0;
           for ($a = 0; $a < count($activity); $a++) {
                if ($data['data'][$i]['idtask'] == $activity[$a]['task_idtask']){
                    if ($activity[$a]['finish'] == null){
                        $data['data'][$i]['acc'] += 1;
                    }
                }
           }
        }
        return $data['data'];
    }
}
