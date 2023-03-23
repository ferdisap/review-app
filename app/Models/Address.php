<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
  use HasFactory;

  protected $connection = 'sqlite';

  protected $fillable = ['id', 'name', 'type', 'latitude', 'longitude', 'parentId'];

  /**
   * Indicates if the model should be timestamped.
   *
   * @var bool
   */
  public $timestamps = false;

  protected $with = ['parent'];

  public function parent()
  {
    return $this->belongsTo(Address::class, 'parentId', 'id');
  }
}
