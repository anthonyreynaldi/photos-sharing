<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostPhotoModel extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'posts_photos';
    protected $primaryKey = 'id';

    protected $fillable = ['id_post', 'id_photo'];

    public $timestamps = false;

    public function add($id_post, $id_photos){
        foreach($id_photos as $id_photo){
            $this->create([
                'id_post' => $id_post,
                'id_photo' => $id_photo,
            ]);
        }
    }
}
