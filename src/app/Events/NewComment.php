<?php

namespace App\Events;

use App\Models\Comment;
use Illuminate\Queue\SerializesModels;

class NewComment
{
    use SerializesModels;

    public Comment $comment;

    public function __construct(
        Comment $comment,
    )
    {
        $this->comment = $comment;
    }

}
