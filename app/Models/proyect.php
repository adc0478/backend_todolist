<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;

class proyect extends Model
{
    public array $output = [
        'status' => false,
        'error' => "",
        'data' => [],
        'info' => ""
    ];
    use HasFactory;
    public function getKeyName():String
    {
        return 'idproyect';
    }
    public function create(String $name):array{
        $search_proyect = proyect::where('nameProyect',$name)->get();
        if (isset($search_proyect[0]['idproyect'])){
            $this->output['error'] = "El proyecto ya existe";
        }else{
            try {
           //cargar el nuevo proyecto
                $data = new proyect();
                $data['nameProyect'] = $name;
                $data->save();
                $this->output['status'] = true;
                $this->output['data'] = $data;
            } catch (Exception $e) {
                $this->output['error']  = "Error al intentar ingresar el nuevo proyecto a la base de datos";
            }
        }

       //ver que el proyecto no exista
        return $this->output;
    }
    public function remove_proyect(int $id):array{
        $model = new proyect();
        try {
            $model::destroy($id);
            $this->output["status"] = true;
            $this->output['info'] = "Proyecto id " . $id . " a sido eliminado";
        } catch (Exception $e) {
            $this->output['error'] = "Error al intentar borrar el proyecto";
        }
        return $this->output;
    }
    public function search_proyect_by_user(String $user_iduser = ""):object{
        $data = [];
        $model_user_has_proyect = new user_has_proyect();
        $data = $model_user_has_proyect->select()
                                        ->where('user_id',$user_iduser)
                                        ->leftjoin('proyects','proyects.idproyect', 'user_has_proyects.proyect_idproyect')->get();
        return  $data;
    }
}
