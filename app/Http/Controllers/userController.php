<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{
    public $output = [
        "error" => "",
        "status" => false,
        "data" => [],
        "info" => "",
        'token' => ""
    ];

    function login (Request $request):object{

        $validation = Validator::make($request->all(),[
            'email'=> 'email|required',
            'password'=>'required'
        ]);
        if ($validation->fails()){
            $this->output['error'] = "Verifique los datos";
        }else{
            $model = new User();
            $response = $model->login_user($request->email, $request->password);
            $this->output['error'] = $response['error'];
            $this->output['status'] = $response['status'];
            $this->output['token'] = $response['data'];
         }

        return response()->json($this->output);
    }
    function re_password(Request $request):object{
        $validate = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
            'new_password' => 'required'
        ]);
        if ($validate->fails()){
            $this->output['error'] = "Verifique sus datos";
        }else {
            $model = new User();
            $response = $model->modify_user($request->email, $request->password, $request->new_password);
            $this->output['error'] = $response['error'];
            $this->output['status'] = $response['status'];
        }
        return response()->json($this->output);
    }
    function close_session():object{
        $model = new User();
        $response = $model->close_session();
        $this->output['status'] = $response;
        return response()->json($this->output);
    }
    function user_create (Request $request):object{
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'required',
            'password' => 'required'
        ]);
        if ($validate->fails()){
            $this->output['error'] = "Verifique los datos ingresados";
        }else{
            $model = new User();
            $response = $model->create_user($request['email'],$request['name'],$request['password']);
            $this->output['error'] = $response['error'];
            $this->output['status'] = $response['status'];
        }
        return response()->json($this->output);
    }

}
