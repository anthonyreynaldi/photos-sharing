<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function isExsist($model, $id){
        return $model->find($id) != null;
    }

    protected function result($msg, $status_code)
    {
        $result['statusCode'] = $status_code;
        $result['message'] = $msg;

        return $result;
    }

    protected function resultOk($msg){
        return $this->result($msg, 200);
    }
    protected function resultError($msg = "Terjadi Kesalahan"){
        return $this->result($msg, 500);
    }
    protected function resultNotFound($msg){
        return $this->result($msg, 404);
    }
}
