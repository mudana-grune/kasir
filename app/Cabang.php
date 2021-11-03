<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    //
    protected $table = 'cabang';
    protected $fillable = ['nama', 'alamat', 'telepon', 'email', 'ig'];

    public function user(){
        return $this->belongsTo(User::class, 'id', 'cabang_id');
    }
}
