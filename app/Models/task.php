<?php

namespace App\Models;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class task extends Model
{
    use HasFactory;
    protected $fillable = [
        'nameTask',
        'proyect_idproyect'
    ];
    public $output = [
        'status' => false,
        'data' => [],
        'info' => "",
        'error' => ""
    ];
    public function getKeyName():String
    {
        return "idtask";
    }
    public function insert (String $name, int $proyect_idproyect):array{
        try {
            $data = task::select()->where('proyect_idproyect', $proyect_idproyect)
                                ->where('nameTask',$name)->get();
            if (isset($data[0]['idtask'])){
                $this->output['error'] = "Ya existe esta actividad en el proyecto actual";
            }else{
                $model = new task();
                $model->nameTask = $name;
                $model->proyect_idproyect = $proyect_idproyect;
                $model->save();
                $this->output['status'] = true;
            }
        } catch (Exception $e) {
            $this->output['error'] = "Error al registrar la actividad";
        }
        return $this->output;
    }
    public function modify (String $name, int $proyect_idproyect, int $idTask):array{

        try {
            $model = task::select()->where("idtask",$idTask)->get();
            if  (isset($model[0]['idtask'])){
                $model[0]->nameTask = $name;
                $model[0]->proyect_idproyect = $proyect_idproyect;
                $model[0]->save();
                $this->output['status'] = true;
            }else{
                $this->output['error'] = "No existe el registro";
            }

        } catch (Exception $e) {
            $this->output['error'] = "Error al intentar modificar el registro";
        }
        return $this->output;
    }
    public function remove (int $idTask):array{
        try {
            $model = new task();
            $model->destroy($idTask);
            $this->output['status'] = true;
        } catch (Exception $e) {
            $this->output['error'] = "Error al intentar eliminar el registro";
        }
        return $this->output;
    }
    public function get_model (string $idtask="", string $idproyect):array{
        $type = "<>";
        if ($idtask != ""){
            $type = "=";
        }
        try {
            $data = task::select()
                                ->where('idtask',$type,$idtask)
                                ->where('proyect_idproyect',$idproyect)->get();
            $this->output['data'] = $data;
            $this->output['status'] = true;
        } catch (Exception $e) {
            $this->output['status'] = false;
            $this->output['error'] = "Error en la operacion de busqueda";
        }

        return $this->output;
    }
}
