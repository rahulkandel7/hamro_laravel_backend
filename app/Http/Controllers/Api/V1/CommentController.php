<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::all();

        return response()->json([
            'data' => $comments,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request)
    {
        $datas = $request->all();
        $datas['user_id'] = auth()->user()->id;
        $comment = Comment::where('product_id', $datas['product_id'])->where('user_id', $datas['user_id'])->first();
        if ($comment) {
            return response()->json([
                'message' => 'You have Already Comment On This Product',
                'status' => true,
                'data' => $comment,
            ], 200);
        } else {
            $data = Comment::create($datas);

            return response()->json([
                'message' => 'The Comment Has Been Published',
                'status' => true,
                'data' => $data,
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(CommentRequest $request, $id)
    {
        $comment = Comment::find($id);
        $data = $comment->update($request->all());
        return response()->json([
            'message' => 'Comment Updated Successfully',
            'status' => true,
            'data' => $data,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json([
            'message' => 'Comment Deleted Successfully',
            'status' => true,
        ], 200);
    }

    public function findComment($id)
    {
        $comment = Comment::where('product_id', $id)->where('user_id', auth()->user()->id)->first();

        return response()->json([
            'data' => $comment,
        ], 200);
    }
}
