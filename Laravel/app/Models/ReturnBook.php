<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ReturnBook
 * 
 * @property int $id
 * @property int $loan_id
 * @property Carbon $return_date
 * 
 * @property Loan $loan
 *
 * @package App\Models
 */
class ReturnBook extends Model
{
	protected $table = 'return_book';
	public $timestamps = false;

	protected $casts = [
		'loan_id' => 'int',
		'return_date' => 'datetime'
	];

	protected $fillable = [
		'loan_id',
		'return_date'
	];

	public function loan()
	{
		return $this->belongsTo(Loan::class);
	}
}
