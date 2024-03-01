<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxSocieteCommerciaux
 *
 * @property int $rowid
 * @property int|null $fk_soc
 * @property int|null $fk_user
 * @property string|null $import_key
 *
 * @package App\Models
 */
class LlxSocieteCommerciaux extends Model
{
	protected $table = 'llx_societe_commerciaux';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_soc' => 'int',
		'fk_user' => 'int'
	];

	protected $fillable = [
		'fk_soc',
		'fk_user',
		'import_key'
	];
}
