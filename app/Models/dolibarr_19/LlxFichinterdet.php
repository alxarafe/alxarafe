<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxFichinterdet
 *
 * @property int $rowid
 * @property int|null $fk_fichinter
 * @property int|null $fk_parent_line
 * @property Carbon|null $date
 * @property string|null $description
 * @property int|null $duree
 * @property int|null $rang
 *
 * @property LlxFichinter|null $llx_fichinter
 *
 * @package App\Models
 */
class LlxFichinterdet extends Model
{
	protected $table = 'llx_fichinterdet';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_fichinter' => 'int',
		'fk_parent_line' => 'int',
		'date' => 'datetime',
		'duree' => 'int',
		'rang' => 'int'
	];

	protected $fillable = [
		'fk_fichinter',
		'fk_parent_line',
		'date',
		'description',
		'duree',
		'rang'
	];

	public function llx_fichinter()
	{
		return $this->belongsTo(LlxFichinter::class, 'fk_fichinter');
	}
}
