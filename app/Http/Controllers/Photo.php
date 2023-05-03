<?php

namespace App\Http\Controllers;

use App\Models\PhotoModel;
use Exception;
use Illuminate\Http\Request;

class Photo extends Controller
{
    public function show($id = null){
        $result = $this->resultOk("Berhasil Mendapatkan Photo");

        $userModel = new PhotoModel();

        if($id == null || $this->isExsist($userModel, $id)){
            $result['data'] = $userModel->find($id);
        }else{
            $result = $this->resultNotFound("Comment Tidak Ditemukan");
        }

        return response()->json($result, $result['statusCode']);
    }
    //
    public function insert(Request $request)
    {
        $result = $this->resultOk("Berhasil Menambahkan Photo");

        try{
            $request->validate([
                'id_user' => 'required|exists:users,id',
                'photo_name' => 'required',
                'photo_file' => 'required'
            ]);
        }
        catch(Exception $e){
            $result = $this->result($e->getMessage(), 422);
            return response()->json($result, $result['statusCode']);
        }

        $id_user = $request->id_user;
        $photo_name = uuid_create() . "-" . $request->photo_name;
        $photo_file = $request->photo_file;


        if(!str_contains($photo_name, "default.png")){
            $datagambar = base64_decode($photo_file);
            file_put_contents("uploads/photos/".$photo_name, $datagambar);
        }

        $photoModel = new PhotoModel();
        $success = $photoModel->add($id_user, $photo_name);

        if(!$success){
            $result = $this->resultError("Terjadi kesalahan");
        }
        
        return response()->json($result, $result['statusCode']  );
    }
}
