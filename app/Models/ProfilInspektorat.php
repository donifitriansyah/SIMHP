<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ProfilInspektorat extends Model
{

    protected $table = 'profil_inspektorat';


    protected $fillable = [

        'nama',
        'alamat',
        'telepon',
        'email',
        'logo'

    ];

}
