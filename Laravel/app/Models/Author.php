<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Author
 * 
 * @property int $id
 * @property string $name
 * 
 * @property Collection|Book[] $books
 *
 * @package App\Models
 */
class Author extends Model
{
	protected $table = 'author';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function books()
	{
		return $this->hasMany(Book::class);
	}
}
