<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCIncoterm
 *
 * @property int $rowid
 * @property string $code
 * @property string|null $label
 * @property string $libelle
 * @property int $active
 *
 * @package App\Models
 */
class LlxCIncoterm extends Model
{
	protected $table = 'llx_c_incoterms';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'active' => 'int'
	];

	protected $fillable = [
		'code',
		'label',
		'libelle',
		'active'
	];
}
