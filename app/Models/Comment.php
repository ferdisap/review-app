<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Comment extends Model
{
  use HasFactory, HasUuids;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = ['description', 'commentator_id', 'post_uuid'];

  /**
   * The primary key associated with the table.
   *
   * @var string
   */
  protected $primaryKey = 'uuid';

  /**
   * The relationships that should always be loaded.
   *
   * @var array
   */
  protected $with = ['commentator'];

  /**
   * Get the columns that should receive a unique identifier.
   *
   * @return array
   */
  public function uniqueIds()
  {
    return ['uuid'];
  }

  /**
   * Generate a new UUID for the model.
   *
   * @return string
   */
  public function newUniqueId()
  {
    return (string) Uuid::uuid4();
  }

  /**
   * add is_mine attribute
   */
  public static function isMine($comment, $param = false)
  {
    $comment->is_mine = $param;
  }

  /**
   * add timeForHuman attributes
   */
  public static function timeForHumans($comment)
  {
    $comment->timeForHuman = $comment->updated_at->diffForHumans();
  }

  /**
   * Get the commentator (user)
   */
  public function commentator()
  {
    return $this->belongsTo(User::class, 'commentator_id', 'id');
  }

  /**
   * default get data ordered by 'updated_at' 'descendant'
   */
  public static function booted()
  {
    static::addGlobalScope('orderedByUpdated_at', function (Builder $builder) {
      $builder->orderBy('updated_at', 'desc');
    });
    static::addGlobalScope('limitQuery', function (Builder $builder) {
      $builder->limit(3);
    });
  }
}
