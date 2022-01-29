<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\Collection;
use Kalnoy\Nestedset\NodeTrait;

class Comment extends Model
{
    use SoftDeletes, HasFactory, NodeTrait;

    protected $fillable = [
        'text',
        'name',
        'reply',
        'parent_id'
    ];

    protected $hidden = [
        '_lft',
        '_rgt',
        'updated_at',
        'deleted_at'
    ];

    protected $appends = ["reply_count"];

    /**
     * show all root comments
     * @return mixed
     */
    public function getRootComment()
    {
        return $this->query()->withDepth()->with('children.children')->orderByDesc('id')->get()->toTree();
    }

    public function getReplyCountAttribute()
    {
        return $this->query()->where('parent_id', $this->id)->count();
    }


}
