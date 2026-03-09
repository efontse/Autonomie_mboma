<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogConnexion extends Model
{
    protected $table = 'logs_connexion';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'email', 'action', 'ip_address', 'user_agent',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
