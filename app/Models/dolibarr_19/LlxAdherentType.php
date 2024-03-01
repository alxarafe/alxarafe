<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxAdherentType
 *
 * @property int $rowid
 * @property int $entity
 * @property Carbon|null $tms
 * @property int $statut
 * @property string $libelle
 * @property string $morphy
 * @property string|null $duration
 * @property string $subscription
 * @property float|null $amount
 * @property int|null $caneditamount
 * @property string $vote
 * @property string|null $note
 * @property string|null $mail_valid
 *
 * @property Collection|LlxAdherent[] $llx_adherents
 *
 * @package App\Models
 */
class LlxAdherentType extends Model
{
	protected $table = 'llx_adherent_type';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'tms' => 'datetime',
		'statut' => 'int',
		'amount' => 'float',
		'caneditamount' => 'int'
	];

	protected $fillable = [
		'entity',
		'tms',
		'statut',
		'libelle',
		'morphy',
		'duration',
		'subscription',
		'amount',
		'caneditamount',
		'vote',
		'note',
		'mail_valid'
	];

	public function llx_adherents()
	{
		return $this->hasMany(LlxAdherent::class, 'fk_adherent_type');
	}
}
