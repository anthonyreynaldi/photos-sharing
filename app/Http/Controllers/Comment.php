<?php

namespace App\Http\Controllers;

use App\Models\CommentModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class Comment extends Controller
{
    public function show($id = null){

        $result = $this->resultOk("Berhasil Mendapatkan Comment");

        $userModel = new CommentModel();

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
        $result = $this->resultOk("Berhasil Menambahkan Comment");

        try{
            $request->validate([
                'id_user' => 'required|exists:users,id',
                'id_post' => 'required|exists:posts,id',
                'comment' => 'required'
            ]);
        }
        catch(Exception $e){
            $result = $this->result($e->getMessage(), 422);
            return response()->json($result, $result['statusCode']);
        }

        $id_user = $request->id_user;
        $id_post = $request->id_post;
        $comment = $request->comment;

        //insert post
        $commentModel = new CommentModel();
        $temp=$commentModel->add($id_user, $id_post, $comment);

        if(!$temp){
            $result = $this->resultError("Terjadi kesalahan");
        }

        return response()->json($result, $result['statusCode']);
    }

    public function delete($id_comment){
        $result = $this->resultOk("Berhasil Menghapus Comment");

        //update post
        $commentModel = new CommentModel();

        if($this->isExsist($commentModel, $id_comment)){
            $temp= $commentModel->del($id_comment);
            if(!$temp){
                $result = $this->resultError("Terjadi kesalahan");
            }

        }else{
            $result = $this->resultNotFound("Comment Tidak Ditemukan");
        }
        
        return response()->json($result, $result['statusCode']);
    }
}
