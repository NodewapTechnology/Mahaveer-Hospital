<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AboutPage extends Model {
    protected $guarded = [];
    protected $casts = ['stats' => 'array', 'values' => 'array'];
}
