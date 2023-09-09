<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    public function storeComment(Request $request)
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:2500']
        ]);

        // No need to validate the ticket id because the request would've failed
        // when the route model binding was done
        $validated['ticket_id'] = $request->ticket;

        # Set the logged-in user as the writer of the ticket
        $validated['user_id'] = Auth::id();

        return Comment::create($validated);
    }
}
