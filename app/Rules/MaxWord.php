<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class MaxWord implements InvokableRule
{
  public $number;

  /**
   * Run the validation rule.
   *
   * @param  string  $attribute
   * @param  mixed  $value
   * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
   * @return void
   */
  public function __invoke($attribute, $value, $fail)
  {
    if (($count = count(explode(' ', $value))) > $this->number){
      $fail('The current word count is ' . $count . '/' . $this->number . '.');
    }
  }
  public function __construct($number)
  {
    $this->number = $number;
  }
}
