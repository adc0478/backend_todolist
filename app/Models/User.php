<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Exception;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    //crear usuario
    //modificar usuario
    //ingresar
    //salir
    public function create_user(String $email, String $name, String $password ):array{
        //Verificar que el usuario no exista en la BD
        $output = [
            'error' => "",
            'status' =>false
        ];
        $search_user = User::select()->where('email',$email)->get();
        if (!isset($search_user[0]['email'])){
            //creo la cuenta
            try {
                $user = new User();
                $user->name = $name;
                $user->email = $email;
                $user->password = Hash::make($password);
                $user->save();
                $output ['status']= true;
            } catch (Exception $e) {
                $output['status'] = false;
                $output['error'] = $e;
            }
        }else{
            $output['status'] = false;
            $output['error'] = 'El  usuario se encuentra registrado';
        }

        return $output;
    }
    public function login_user (String $email, String $password):array{
        $output = [
            'error' => "",
            'status' =>false,
            'data' => ''
        ];
        $search_user = User::select()->where('email',$email)->get();
        if (isset($search_user[0]['email'])){
            if (Hash::check($password, $search_user[0]['password'])){
                $token = $search_user[0]->createToken('auth')->plainTextToken;
                $output['status'] =true;
                $output['data'] = $token;
            }else{
                $output['error'] = 'Password incorrecto';
            }
        }else{
            $output['error'] = 'El  usuario  no se  encuentra registrado';
        }
        return $output;
    }
    public function close_session():bool{
        try {
            auth()->user()->currentAccessToken()->delete();
            return true;

        } catch (Exception $e) {

            return false;
        }

   }
    public function modify_user(String $email, String $password, String $new_password):array{
       $output = [
            'status' => false,
            'error' => ""
        ];
        $search_user = User::select()->where('email',$email)->get();
        if (isset($search_user[0]['email']) && Hash::check($password,$search_user[0]['password'])){
            try {
                $search_user[0]['password'] = Hash::make($new_password);
                $output['status'] = true;
            } catch (Exception $e) {
                $output['error'] = $e;
            }
        }else{
            $output['error'] = "No existe el usuario";
        }
        return $output;
    }
}
