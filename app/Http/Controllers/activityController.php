<?php

namespace App\Http\Controllers;

use App\Models\activity;
use App\Models\user_has_proyect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class activityController extends Controller
{
  public $output = [
        "status" =>false,
        "data" => [],
        "Datauser_proyect" =>[],
        "info" => "",
        "error" => ""
    ];

    public function store(Request $request):object{
        $validate = Validator::make($request->all(),[
            'detailActivity' => "required",
            'proyect_idproyect' => "required|int",
            'task_idtask' => "required|int",
            'start' =>"regla_fechas:start,finish"
        ]);
        if ($validate->fails()){
            $this->output['error']  = "Verifique los datos suministrados";
        }else {
           $activity = new activity();
            $response = $activity->insert($request['start'],$request['finish'],$request['detailActivity'],$request['proyect_idproyect'],$request['task_idtask']);
            $this->output['error'] = $response['error'];
            $this->output['status'] = $response['status'];
            $this->output['data'] = $this->list_activity($request['task_idtask']);
        }
        return response()->json($this->output);
    }
    public function remove(Request $request):object{
        $validate = Validator::make($request->all(),[
            'idactivity' => "required|int",
            'task_idtask' => "required|int"
        ]);
        if ($validate->fails()){
            $this->output['error']  = "Verifique los datos suministrados";
        }else {
           $activity = new activity();
            $response = $activity->remove($request->idactivity);
            $this->output['error'] = $response['error'];
            $this->output['status'] = $response['status'];
            $this->output['data'] = $this->list_activity($request['task_idtask']);
        }
        return response()->json($this->output);
    }
    public function modify(Request $request):object{
        $validate = Validator::make($request->all(),[
            'detailActivity' => "required",
            'idactivity' => "required",
            'task_idtask' => "required",
            'start' =>"regla_fechas:start,finish"
        ]);
        if ($validate->fails()){
            $this->output['error']  = "Verifique los datos suministrados";
        }else {
            $activity = new activity();
            $response = $activity->modify($request['idactivity'],$request['start'],$request['finish'],$request['detailActivity']);
            $this->output['error'] = $response['error'];
            $this->output['status'] = $response['status'];
            $this->output['data'] = $this->list_activity($request['task_idtask']);
        }
        return response()->json($this->output);
    }   //
    public function list_activity(int $idtask ):object{
        $activity = new activity();
        return $activity->list_activity($idtask);
    }

    public function list_custon_activity(Request $request):object{
        $this->output['data'] =  $this->list_activity($request['task_idtask']);
        $this->output['status'] = true;
        return response()->json($this->output);
    }
}
