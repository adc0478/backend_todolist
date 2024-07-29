<?php

namespace App\Http\Controllers;

use App\Models\rolleList;
use Illuminate\Http\Request;

class table_role_Controller extends Controller
{
    public $out = [
        'data' =>[]
    ];
    public function search_list():Object{
        $model = new rolleList();
        $this->out['data'] = $model->list_all();
        return response()->json($this->out);
    }
}
