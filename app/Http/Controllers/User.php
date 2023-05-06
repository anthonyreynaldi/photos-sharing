<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Exception;
use Illuminate\Http\Request;

class User extends Controller
{
    //
    public function show($id = null)
    {
        $result = $this->resultOk("Berhasil Mendapatkan User");

        $userModel = new UserModel();

        if($id == null || $this->isExsist($userModel, $id)){
            $result['data'] = $userModel->search($id);
        }else{
            $result = $this->resultNotFound("User Tidak Ditemukan");
        }

        return response()->json($result, $result['statusCode']);
    }

    public function showPhotos($id)
    {
        $result = $this->resultOk("Berhasil Mendapatkan Photos User");

        $userModel = new UserModel();

        if($id == null || $this->isExsist($userModel, $id)){
            $result['data'] = $userModel->searchUserPhotos($id);
        }else{
            $result = $this->resultNotFound("User Tidak Ditemukan");
        }

        return response()->json($result, $result['statusCode']);
    }
    
    public function showPosts($id)
    {
        $result = $this->resultOk("Berhasil Mendapatkan Posts User");

        $userModel = new UserModel();

        if($id == null || $this->isExsist($userModel, $id)){
            $result['data'] = $userModel->searchUserPosts($id);
        }else{
            $result = $this->resultNotFound("User Tidak Ditemukan");
        }

        return response()->json($result, $result['statusCode']);
    }
    
    public function insert(Request $request)
    {
        $result = $this->resultOk("Berhasil Menambahkan User");

        try{
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);
        }
        catch(Exception $e){
            $result = $this->result($e->getMessage(), 422);
            return response()->json($result, $result['statusCode']);
        }

        $userModel = new UserModel();

        $name = $request->name;
        $email = $request->email;
        $password = $request->password;

        $temp = $userModel->add($name, $email, $password);
        
        if(!$temp){
            $result = $this->resultError("Terjadi kesalahan");
        }

        return response()->json($result, $result['statusCode']);
    }
    
    public function update(Request $request, $id)
    {
        $result = $this->resultOk("Berhasil Mengupdate User");

        try{
            $request->validate([
                'email' => 'email|unique:users,email',
            ]);
        }
        catch(Exception $e){
            $result = $this->result($e->getMessage(), 422);
            return response()->json($result, $result['statusCode']);
        }
        
        $userModel = new UserModel();

        $name = $request->name;
        $email = $request->email;
        $password = $request->password;

        if($this->isExsist($userModel, $id)){
            $temp = $userModel->up($id, $name, $email, $password);

            if(!$temp){
                $result = $this->resultError();
            }
        }else{
            $result = $this->resultNotFound("User Tidak Ditemukan");
        }

        return response()->json($result, $result['statusCode']);
    }
    
    public function delete($id = null)
    {
        $result = $this->resultOk("Berhasil Menghapus User");

        $userModel = new UserModel();

        if($this->isExsist($userModel, $id)){
            $temp = $userModel->del($id);

            if(!$temp){
                $result = $this->resultError();
            }
        }else{
            $result = $this->resultNotFound("User Tidak Ditemukan");
        }
    
        return response()->json($result, $result['statusCode']);
    }
}
