<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxChargesociale
 *
 * @property int $rowid
 * @property string|null $ref
 * @property Carbon $date_ech
 * @property string $libelle
 * @property int $entity
 * @property Carbon|null $tms
 * @property Carbon|null $date_creation
 * @property Carbon|null $date_valid
 * @property int|null $fk_user
 * @property int|null $fk_user_author
 * @property int|null $fk_user_modif
 * @property int|null $fk_user_valid
 * @property int $fk_type
 * @property int|null $fk_account
 * @property int|null $fk_mode_reglement
 * @property float $amount
 * @property int $paye
 * @property Carbon|null $periode
 * @property int|null $fk_projet
 * @property string|null $note_private
 * @property string|null $note_public
 * @property string|null $import_key
 *
 * @package App\Models
 */
class LlxChargesociale extends Model
{
	protected $table = 'llx_chargesociales';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'date_ech' => 'datetime',
		'entity' => 'int',
		'tms' => 'datetime',
		'date_creation' => 'datetime',
		'date_valid' => 'datetime',
		'fk_user' => 'int',
		'fk_user_author' => 'int',
		'fk_user_modif' => 'int',
		'fk_user_valid' => 'int',
		'fk_type' => 'int',
		'fk_account' => 'int',
		'fk_mode_reglement' => 'int',
		'amount' => 'float',
		'paye' => 'int',
		'periode' => 'datetime',
		'fk_projet' => 'int'
	];

	protected $fillable = [
		'ref',
		'date_ech',
		'libelle',
		'entity',
		'tms',
		'date_creation',
		'date_valid',
		'fk_user',
		'fk_user_author',
		'fk_user_modif',
		'fk_user_valid',
		'fk_type',
		'fk_account',
		'fk_mode_reglement',
		'amount',
		'paye',
		'periode',
		'fk_projet',
		'note_private',
		'note_public',
		'import_key'
	];
}
