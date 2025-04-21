<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Reader
 * 
 * @property int $id
 * @property string $full_name
 * @property string $email
 * 
 * @property Collection|Loan[] $loans
 *
 * @package App\Models
 */
class Reader extends Model
{
	protected $table = 'reader';
	public $timestamps = false;

	protected $fillable = [
		'full_name',
		'email'
	];

	public function loans()
	{
		return $this->hasMany(Loan::class);
	}
}
