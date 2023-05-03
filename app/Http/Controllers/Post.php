<?php

namespace App\Http\Controllers;

use App\Models\PostModel;
use App\Models\PostPhotoModel;
use Exception;
use Illuminate\Http\Request;

class Post extends Controller
{
    public function show($id = null, $comments = false){
        $result = $this->resultOk("Berhasil Mendapatkan Post");

        $userModel = new PostModel();

        if($id == null || $this->isExsist($userModel, $id)){
            if($comments){
                $result['data'] = $userModel->comments($id);

            }else{
                $result['data'] = $userModel->find($id);
            }
        }else{
            $result = $this->resultNotFound("Post Tidak Ditemukan");
        }

        return response()->json($result, $result['statusCode']);
    }
    
    public function showComments($id = null){
        return $this->show($id, true);
    }


    //
    public function insert(Request $request)
    {
        $result = $this->resultOk("Berhasil Menambahkan Post");

        //validate
        try{
            $request->validate([
                'id_user' => 'required|exists:users,id',
                'id_photos' => 'required|exists:photos,id',
            ]);
        }
        catch(Exception $e){
            $result = $this->result($e->getMessage(), 422);
            return response()->json($result, $result['statusCode']);
        }

        $id_user = $request->id_user;
        $caption = $request->caption;
        $id_photos = $request->id_photos;

        //insert post
        $postModel = new PostModel();
        $id_post = $postModel->add($id_user, $caption);

        if(!$id_post){
            $result = $this->resultError();
            return response()->json($result, $result['statusCode']);
        }

        //insert photos
        $postPhotoModel = new PostPhotoModel();
        $postPhotoModel->add($id_post, $id_photos);

        return response()->json($result, $result['statusCode']);
    }

    public function update(Request $request, $id_post)
    {
        $result = $this->resultOk("Berhasil Mengupdate Post");

        $caption = $request->caption;

        //update post
        $postModel = new PostModel();

        if($this->isExsist($postModel, $id_post)){
            $temp= $postModel->up($id_post, $caption);
    
            if(!$temp){
                $result = $this->resultError();
            }
        }else{
            $result = $this->resultNotFound("Post Tidak Ditemukan");
        }

        return response()->json($result, $result['statusCode']);
    }

    public function delete($id_post){
        $result = $this->resultOk("Berhasil Menghapus Post");
        
        //update post
        $postModel = new PostModel();
        if($this->isExsist($postModel, $id_post)){
            $temp = $postModel->del($id_post);
    
            if(!$temp){
                $result = $this->resultError();
            }
        }else{
            $result = $this->resultNotFound("Post Tidak Ditemukan");
        }

        return response()->json($result, $result['statusCode']);
    }
}
