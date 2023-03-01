<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
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
}
