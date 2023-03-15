<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Post extends Model
{
  use HasFactory, HasUuids;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'isDraft',
    'author_id',
    'category_id',
  ];

  /**
   * The primary key associated with the table.
   *
   * @var string
   */
  protected $primaryKey = 'uuid';

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
   * Get the columns that should receive a unique identifier.
   *
   * @return array
   */
  public function uniqueIds()
  {
    return ['uuid'];
  }

  /**
   * scope a query for search fiture
   */
  public function scopeSearch($query, $keyword)
  {
    return $query->where('title', 'like', '%' . $keyword . '%')
      ->orWhere('simpleDescription', 'like', '%' . $keyword . '%')
      ->orWhere('detailDescription', 'like', '%' . $keyword . '%');
  }

  /**
   * Belongs to User
   */
  public function author()
  {
    return $this->belongsTo(User::class, 'author_id');
  }

  /**
   * Get the comments for the post.
   */
  public function comments()
  {
    return $this->hasMany(Comment::class, 'post_uuid', 'uuid');
  }

  /**
   * Get the category of the post
   */
  public function category()
  {
    return $this->hasOne(Category::class, 'id', 'category_id');
  }

   /**
   * add category_name attribute
   */
  public static function category_name($post, $param = null)
  {
    $post->category_name = $param;
  }

  /**
   * selecting default column when get the data
   */
  // public static function booted()
  // {
  //   static::addGlobalScope('defaultColumnSelected', function (Builder $builder) {
  //     $builder->select(['uuid', 'title', 'simpleDescription', ]);
  //   });
  // }
}
