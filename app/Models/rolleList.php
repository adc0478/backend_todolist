<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rolleList extends Model
{
    use HasFactory;
    public function list_all():Object{
        $data = rolleList::all();
        return $data;
    }
}
