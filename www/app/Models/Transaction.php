<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

	public function IsExpense() 
	{
		return $this->value < 0;
	}

	public function AbsoluteValue()
	{
		return abs($this->value);
	}
}
