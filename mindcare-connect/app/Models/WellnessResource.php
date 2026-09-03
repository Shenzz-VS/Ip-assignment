<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WellnessResource extends Model
{
    protected $fillable = [
        'admin_id',
        'title',
        'description',
        'content',
        'tags',
        'video_url',
        'context_or_url'
    ];

    public function getEmbedUrlAttribute()
    {
        if (!$this->video_url) {
            return null;
        }

        $url = $this->video_url;
        
        // Convert youtube.com/watch?v=ID to youtube.com/embed/ID
        if (str_contains($url, 'youtube.com/watch?v=')) {
            $url = str_replace('watch?v=', 'embed/', $url);
            $url = explode('&', $url)[0]; // Removes extra timecodes or playlist tags
        } 
        // Convert youtu.be/ID to youtube.com/embed/ID
        elseif (str_contains($url, 'youtu.be/')) {
            $url = str_replace('youtu.be/', 'youtube.com/embed/', $url);
        }
        
        return $url;
    }
}
