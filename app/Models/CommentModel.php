<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommentModel extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $table = 'comments'; 
    protected $primaryKey = 'id';

    protected $fillable = ['id_user', 'id_post', 'comment'];

    public function find($id = null)
    {
        if($id){
            $result = $this->select(['id', 'id_user', 'id_post', 'comment'])->where('id', $id)->first();
        }else{
            $result = $this->all(['id', 'id_user', 'id_post', 'comment']);
        }

        return $result;
    }

    public function add($id_user, $id_post, $comment){
        $this->id_user = $id_user;
        $this->id_post = $id_post;
        $this->comment = $comment;
        $this->save();
        return $this->id;
    }

    public function del($id_post)
    {
        return $this->where('id', $id_post)->delete();
    }
}
