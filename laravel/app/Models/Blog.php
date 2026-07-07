<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Blog extends Model {
    protected $guarded = [];
    protected $casts = ['published_at' => 'date', 'is_active' => 'boolean'];
}
