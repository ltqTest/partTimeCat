<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = [
        'title',
        'body',
        'category_id',
        'reply_count',
        'view_count',
    ];

    /**
     * 关联Category模型
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * 关联User模型
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 关联Reply模型
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * 加载话题前5条回复
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function topReplies()
    {
        return $this->replies()->limit(5);
    }

    /**
     * 根据不同的排序，使用不同的数据读取逻辑
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param $order mixed 排序方式（动态范围参数）
     * @return mixed 预加载防止 N+1 问题
     */
    public function scopeWithOrder($query, $order)
    {
        switch ($order) {
            case 'recent':
                $query->recent();
                break;

            default:
                $query->recentReplied();
                break;
        }

        return $query->with('user', 'category');
    }

    /**
     * 当话题有新回复时，我们将编写逻辑来更新话题模型的 reply_count 属性，并且会自动触发框架对数据模型 updated_at 时间戳的更新
     * @param $query
     * @return mixed
     */
    public function scopeRecentReplied($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    /**
     * 按照创建时间排序
     * @param $query
     * @return mixed
     */
    public function scopeRecent($query)
    {
        //
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * @param array $params 允许附加 URL 参数的设定
     * @return string
     */
    public function link($params = [])
    {
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }

    /**
     * 回复数量的更新
     */
    public function updateReplyCount()
    {
        $this->reply_count = $this->replies->count();
        $this->save();
    }
}
