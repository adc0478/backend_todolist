<?php

namespace App\Http\Middleware;

use App\Models\user_has_proyect;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserRolValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public $out = [
        'status' =>false,
        'error' => 'Usuario no permitido'
    ];
    public function handle(Request $request, Closure $next,string $rolle): Response
    {
        $array = [];
        //consultar en user_has_proyect con el idproyect y el id de usuario el tipo        //En el request se trae el idproyect
        $data = user_has_proyect::where('proyect_idproyect',$request['proyect_idproyect'])->where('user_id',Auth::id())->get();
        //ver su obtengo un resultado
        if (!isset($data[0])){
            return response()->json($this->out);
        }
        $array = explode(',',$data[0]['type_user']);
        if (in_array($rolle,$array) or in_array('adm',$array)){
            return $next($request);
        }else{
            return response()->json($this->out);
        }
    }
}
