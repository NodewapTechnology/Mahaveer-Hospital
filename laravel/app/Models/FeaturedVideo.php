<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FeaturedVideo extends Model {
    protected $guarded = [];
    protected $casts = ['is_active' => 'boolean'];

    // Extract a YouTube video id from any common URL form
    public function youtubeId(): ?string
    {
        if (preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|shorts/|v/))([A-Za-z0-9_-]{11})~', (string) $this->url, $m)) {
            return $m[1];
        }
        return null;
    }
}
