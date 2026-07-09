<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Banner extends Model {
    protected $guarded = [];
    protected $casts = ['translations' => 'array', 'is_active' => 'boolean'];
}
