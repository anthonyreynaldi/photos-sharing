<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostModel extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $table = 'posts'; 
    protected $primaryKey = 'id';

    protected $fillable = ['id_user', 'caption'];

    public function search($id = null)
    {
        if($id){
            $result = $this->select(['posts.id', 'posts.id_user', 'posts.caption'])->where('id', $id)->first();

            if($result){
                $photos = $this->select(['id_photo'])->join('posts_photos', 'posts.id', '=', 'posts_photos.id_post')->where('posts_photos.id_post', $id)->get();
                foreach($photos as $i => $photo){
                    $photos[$i] = $photo['id_photo'];
                }
    
                $result->photos = $photos;
            }
    
        }else{
            $result = $this->all(['id', 'id_user', 'caption']);
        }

        return $result;
    }
    
    public function comments($id = null)
    {
        $comments = $this->select(['comments.id'])->join('comments', 'posts.id', '=', 'comments.id_post')->where('comments.id_post', $id)->get();
        foreach($comments as $i => $comment) {
            $comments[$i] = $comment['id'];
        }

        return $comments;
    }

    public function add($id_user, $caption){
        $this->id_user = $id_user;
        $this->caption = $caption;
        $this->save();
        return $this->id;

        // return $this->create([
        //     'name' => $name,
        //     'email' => $email,
        //     'password' => $password
        // ]);
    }

    public function up($id_post, $caption)
    {
        $post = $this->find($id_post);
        $post->caption = $caption;
        $post->save();
        
        return $post;
    }    

    public function del($id_post)
    {
        return $this->where('id', $id_post)->delete();
    }
}
