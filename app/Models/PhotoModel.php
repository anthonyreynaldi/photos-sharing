<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoModel extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'photos';
    protected $primaryKey = 'id';

    protected $fillable = ['id_user', 'photo_name'];

    public function find($id = null)
    {
        if($id){
            $result = $this->where('id', $id)->first();
        }else{
            $result = $this->all();
        }

        return $result;
    }

    public function add($id_user, $photo_name){
        return $this->create([
            'id_user' => $id_user,
            'photo_name' => $photo_name,
        ]);
    }
}
