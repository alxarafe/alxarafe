<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCRevenuestamp
 *
 * @property int $rowid
 * @property int $fk_pays
 * @property float $taux
 * @property string $revenuestamp_type
 * @property string|null $note
 * @property int $active
 * @property string|null $accountancy_code_sell
 * @property string|null $accountancy_code_buy
 *
 * @package App\Models
 */
class LlxCRevenuestamp extends Model
{
	protected $table = 'llx_c_revenuestamp';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_pays' => 'int',
		'taux' => 'float',
		'active' => 'int'
	];

	protected $fillable = [
		'fk_pays',
		'taux',
		'revenuestamp_type',
		'note',
		'active',
		'accountancy_code_sell',
		'accountancy_code_buy'
	];
}
