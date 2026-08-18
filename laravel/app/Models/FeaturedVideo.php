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

    // Instagram post/reel/tv shortcode
    public function instagramShortcode(): ?string
    {
        if (preg_match('~instagram\.com/(?:[^/]+/)?(?:reel|reels|p|tv)/([A-Za-z0-9_-]+)~', (string) $this->url, $m)) {
            return $m[1];
        }
        return null;
    }

    // Best-effort real thumbnail for an Instagram post (public CDN media endpoint).
    // Front-end falls back to a branded glass card if this fails to load.
    public function instagramThumb(): ?string
    {
        $code = $this->instagramShortcode();
        return $code ? "https://www.instagram.com/p/{$code}/media/?size=l" : null;
    }
}
