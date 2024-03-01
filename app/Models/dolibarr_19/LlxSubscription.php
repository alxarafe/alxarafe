<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxSubscription
 *
 * @property int $rowid
 * @property Carbon|null $tms
 * @property Carbon|null $datec
 * @property int|null $fk_adherent
 * @property int|null $fk_type
 * @property Carbon|null $dateadh
 * @property Carbon|null $datef
 * @property float|null $subscription
 * @property int|null $fk_bank
 * @property int|null $fk_user_creat
 * @property int|null $fk_user_valid
 * @property string|null $note
 *
 * @package App\Models
 */
class LlxSubscription extends Model
{
	protected $table = 'llx_subscription';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'tms' => 'datetime',
		'datec' => 'datetime',
		'fk_adherent' => 'int',
		'fk_type' => 'int',
		'dateadh' => 'datetime',
		'datef' => 'datetime',
		'subscription' => 'float',
		'fk_bank' => 'int',
		'fk_user_creat' => 'int',
		'fk_user_valid' => 'int'
	];

	protected $fillable = [
		'tms',
		'datec',
		'fk_adherent',
		'fk_type',
		'dateadh',
		'datef',
		'subscription',
		'fk_bank',
		'fk_user_creat',
		'fk_user_valid',
		'note'
	];
}
