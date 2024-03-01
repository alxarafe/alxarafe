<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxFactureRecExtrafield
 *
 * @property int $rowid
 * @property Carbon|null $tms
 * @property int $fk_object
 * @property string|null $import_key
 *
 * @package App\Models
 */
class LlxFactureRecExtrafield extends Model
{
	protected $table = 'llx_facture_rec_extrafields';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'tms' => 'datetime',
		'fk_object' => 'int'
	];

	protected $fillable = [
		'tms',
		'fk_object',
		'import_key'
	];
}
