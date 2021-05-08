<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $table = 'photo';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'url_photo',
        'name_photo',
        'id_agenda'
    ];

    protected $guarded = ['id'];

    protected $hidden = ['created_at','updated_at'];

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }
}
