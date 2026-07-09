<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class WebsiteSetting extends Model {
    protected $guarded = [];
    protected $casts = ['translations' => 'array', 'language_switch_enabled' => 'boolean'];
}
