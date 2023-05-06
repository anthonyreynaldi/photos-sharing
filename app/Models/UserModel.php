<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserModel extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'email', 'password'];

    public function search($id = null)
    {
        if($id){
            $result = $this->select(['id', 'name', 'email'])->where('id', $id)->first();

        }else{
            $result = $this->all(['id', 'name', 'email']);
        }

        return $result;
    }

    public function searchUserPhotos($id)
    {
        $photos = $this->select(['photos.id'])->join('photos', 'users.id', '=', 'photos.id_user')->where('users.id', $id)->get();
    
        foreach($photos as $i => $photo){
            $photos[$i] = $photo['id'];
        }

        return $photos;
    }
    
    public function searchUserPosts($id)
    {
        $posts = $this->select(['posts.id'])->join('posts', 'users.id', '=', 'posts.id_user')->where('users.id', $id)->get();
    
        foreach($posts as $i => $post){
            $posts[$i] = $post['id'];
        }

        return $posts;
    }

    public function add($name, $email, $password){
        return $this->create([
            // 'id' => uuid_create(),
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);
    }

    public function up($id, $name = null, $email = null, $password = null)
    {
        $user = $this->find($id);

        if($name){
            $user->name = $name;
            $this->where('id', $id)->update(['name' => $name]);
        }
        
        if($email){
            $user->email = $email;
            $this->where('id', $id)->update(['email' => $email]);
        }
        
        if($password){
            $user->password = $password;
            $this->where('id', $id)->update(['password' => $password]);
        }

        $user->save();

        return $user;
    }    

    public function del($id)
    {
        return $this->where('id', $id)->delete();
    }
}
