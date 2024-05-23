<?php

namespace App\Models;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class user_has_proyect extends Model
{
    use HasFactory;
    public function getKeyName():String
    {
       return "id_user_proyect";
    }
    public array $output = [
        'status' => false,
        'error' => "",
        'data' => [],
        'data_user' => [],
        'info' => ""
    ];
    public function modify(string $idproyect,string $type):array{

        $model = user_has_proyect::find($idproyect);
       try {
            $model->type_user = $type;
            $model->save();
            $this->output['status'] = true;
       } catch (Exception $e) {
            $this->output['error'] = "Error al registrar la referencia";
       }
        return $this->output;

    }
    public function register(String $id_proyect,String $id_user, String $type):array{
       try {
            $model = new user_has_proyect();
            $model->user_id = $id_user;
            $model->proyect_idproyect = $id_proyect;
            $model->type_user = $type;
            $model->save();
            $this->output['status'] = true;
       } catch (Exception $e) {
            $this->output['error'] = "Error al registrar la referencia";
       }
        return $this->output;
    }
    public function remove(String $id):array{
        try {
           $response = user_has_proyect::destroy($id);
            $this->output['status'] = true;
        } catch (Exception $e) {
            $this->output['error'] = "Hubo un error al intentar borrar la asignaciòn";
        }

        return $this->output;
    }
    public function search_relation_user_proyect(String $idproyect):array{
        $column = "users.id,users.name, users.email,user_has_proyects.type_user,user_has_proyects.id_user_proyect";
        $query = "select ".$column ." from users left join user_has_proyects on user_has_proyects.user_id = users.id and user_has_proyects.proyect_idproyect =" . $idproyect;
        $data = DB::select($query);
        $this->output['data'] = $data;
        return $this->output;
    }
}
