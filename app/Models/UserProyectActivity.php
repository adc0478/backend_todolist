<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;
class UserProyectActivity extends Model
{
    use HasFactory;
    public $out = [
                    'data' => [],
                    'data_user' =>[],
                    'data_active_user' => [],
                    'state' =>false,
                    'error' =>""
                ];
    public function store(string $iduser, string $idactivity, string $idproyect):Array{
        $search_data = UserProyectActivity::where('UserProyect_iduser',$iduser, 'and' , 'activities_idactivity',$idactivity)->get();
        if (isset($search_data[''])){
            $this->out['error'] = "Esta relacion ya se encuentra activa";
            $this->out['state'] = false;
        }else{
            try {
                $model = new UserProyectActivity();
                $model->UserProyect_iduser = $iduser;
                $model->activities_idactivity = $idactivity;
                $model->save();
                $this->out['state'] = true;
            } catch (Exception $e) {
                $this->out['error'] = $e->getMessage();
                $this->out['state'] = false;
            }
            if ($this->out['state']){
                $this->search_view($idactivity, $idproyect);
            }
        }

        return $this->out;
    }
    public function delete_relation(string $idrelation, string $idactivity, string $idproyect):Array{
        try {
            UserProyectActivity::destroy($idrelation);
            $this->out['state'] = true;
        } catch (Exception $e) {
            $this->out['state'] = false;
            $this->out['error'] = $e->getMessage();
        }
        if ($this->out['state']){
            $this->search_view($idactivity, $idproyect);
        }
        return $this->out;
    }
    public function search_view(string $idactivity, string $idproyect):Array{
        //Obtener los usuarios activos para un activity en particular
        $this->out['data_active_user'] = UserProyectActivity::where('UserProyect_iduser',$idactivity)
                                        ->join('users','id.users','UserProyect_iduser.user_proyect_activies')
                                        ->get();
        //Obtener la lista de usuarios activos en un proyecto en particular
        $model = new user_has_proyect();
        $this->out['data_user'] = $model->search_relation_user_proyect($idproyect);
        return $this->out;
        //esto me devuelve los usuarios activos para el proyecto y los usuarios activos para una actividad en particular

    }
}
