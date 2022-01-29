<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\comment\ShowCommentRequest;
use App\Http\Requests\comment\StoreCommentRequest;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    protected $model;

    public function __construct(Comment $comment)
    {
        $this->model=$comment;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCommentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request)
    {
        $inputs=$request->all();
        $comment=$this->model->createModel($inputs);
        if ($comment)
            return success('comment Show Successfully',$comment);
        else
            return failed('An Unknown Error Has Happened',500);

    }
    /**
     * Get all root comments
     *
     * @return JsonResponse
     */
    public function roots()
    {
        return success('Root Comment list.', $this->model->getRootComment());
    }
}
