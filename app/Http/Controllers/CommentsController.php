<?php

namespace App\Http\Controllers;

use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct(protected CommentService $commentService)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->commentService->storeComment($request);
        
        return redirect()->back();
    }
}
