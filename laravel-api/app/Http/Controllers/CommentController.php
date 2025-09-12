<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        $comments = $product->comments()->with('user:id,name')->get();
        return response()->json($comments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request, Product $product)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $comment = $product->comments()->create($data);
        return response()->json($comment->load('user:id,name'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment, Product $product)
    {
        return response()->json($comment->load('user:id,name'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(CommentRequest $request,  Product $product ,Comment $comment)
    {
        $this->authorize('update', $comment);
        $comment->update($request->validated());
        return response()->json($comment->load('user:id,name'));
    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy(Product $product, Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return response()->json(['message' => 'Comment delete']);
    }
}
