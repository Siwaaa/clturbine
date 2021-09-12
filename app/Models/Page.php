<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $fillable = [

    ];
    protected $hidden = [
        'id', 'created_at'
    ];

    public function template()
    {
        return $this->hasOne(Template::class);
    }
    public function domain()
    {
        return $this->hasOne(Domain::class);
    }
    public function user()
    {
        return $this->hasOne(User::class);
    }

}
