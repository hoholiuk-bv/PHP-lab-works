<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Loan
 * 
 * @property int $id
 * @property int $book_id
 * @property int $reader_id
 * @property Carbon $loan_date
 * 
 * @property Book $book
 * @property Reader $reader
 * @property ReturnBook|null $return_book
 *
 * @package App\Models
 */
class Loan extends Model
{
	protected $table = 'loan';
	public $timestamps = false;

	protected $casts = [
		'book_id' => 'int',
		'reader_id' => 'int',
		'loan_date' => 'datetime'
	];

	protected $fillable = [
		'book_id',
		'reader_id',
		'loan_date'
	];

	public function book()
	{
		return $this->belongsTo(Book::class);
	}

	public function reader()
	{
		return $this->belongsTo(Reader::class);
	}

	public function return_book()
	{
		return $this->hasOne(ReturnBook::class);
	}
}
