<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;

class activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'idactivity',
        'finish',
        'start',
    ];
    public $output = [
        'status' => false,
        'data' => [],
        'info' => "",
        'error' => ""
    ];
    public function getKeyName():string{
        return "idactivity";
    }

    public function insert (String $start, String|null $finish=null, String $deteilActivity, int $proyect_idproyect, int $task_idtask):array{
        try {
            $model = new activity();
            $model->start = $start;
            $model->finish = $finish;
            $model->proyect_idproyect = $proyect_idproyect;
            $model->task_idtask = $task_idtask;
            $model->detailActivity = $deteilActivity;
            $model->save();
            $this->output['status'] = true;
        } catch (Exception $e) {
            $this->output['error'] = $e;//"Error al registrar la actividad";
            $this->output['status'] = false;
        }
        return $this->output;
    }
    public function modify (int $idactivity,String $start, String $finish, String $deteilActivity):array{

        try {
            $model = activity::select()->where("idactivity",$idactivity)->get();
            if  (isset($model[0]['idactivity'])){
                $model[0]->start = $start;
                if ($finish == "null"){
                    $finish = null;
                }
                $model[0]->finish = $finish;
                $model[0]->detailActivity = $deteilActivity;

                $model[0]->save();
                $this->output['status'] = true;
            }else{
                $this->output['error'] = "No existe el registro";
            }

        } catch (Exception $e) {
            $this->output['error'] = "No fue posible modificar el valor";
        }
        return $this->output;
    }
    public function remove (int $idactivity):array{
        try {
            $model = new activity();
            $model->destroy($idactivity);
            $this->output['status'] = true;
        } catch (Exception $e) {
            $this->output['error'] = "Error al intentar eliminar el registro";
        }
        return $this->output;
    }
    public function list_activity(string $idtask):object{
        return activity::where('task_idtask',$idtask)->get();
    }
}
