<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Offer extends Model {
    protected $guarded = [];
    protected $casts = ['valid_from' => 'date', 'valid_until' => 'date', 'is_active' => 'boolean', 'translations' => 'array'];
}
