<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Book
 * 
 * @property int $id
 * @property int $author_id
 * @property string $title
 * @property string $isbn
 * 
 * @property Author $author
 * @property Collection|Loan[] $loans
 *
 * @package App\Models
 */
class Book extends Model
{
	protected $table = 'book';
	public $timestamps = false;

	protected $casts = [
		'author_id' => 'int'
	];

	protected $fillable = [
		'author_id',
		'title',
		'isbn'
	];

	public function author()
	{
		return $this->belongsTo(Author::class);
	}

	public function loans()
	{
		return $this->hasMany(Loan::class);
	}
}
