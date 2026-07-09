<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UiTranslation extends Model
{
    protected $fillable = ['key', 'en_value', 'hi_value', 'group', 'note'];
}
