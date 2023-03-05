<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Comment extends Model
{
  use HasFactory;

  protected $fillable = ['description', 'comentator_id', 'post_id'];

  /**
   * The primary key associated with the table.
   *
   * @var string
   */
  protected $primaryKey = 'uuid';

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
}
