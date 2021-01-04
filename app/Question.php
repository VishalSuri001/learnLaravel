<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Poll;

class Question extends Model
{
    protected $fillable = [ 'title', 'question', 'poll_id' ];

    /**
     * Get the post that owns the comment.
     */
    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }
}
