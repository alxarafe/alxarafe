<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxMailingUnsubscribe
 *
 * @property int $rowid
 * @property int $entity
 * @property string|null $email
 * @property string|null $unsubscribegroup
 * @property string|null $ip
 * @property Carbon|null $date_creat
 * @property Carbon|null $tms
 *
 * @package App\Models
 */
class LlxMailingUnsubscribe extends Model
{
	protected $table = 'llx_mailing_unsubscribe';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'date_creat' => 'datetime',
		'tms' => 'datetime'
	];

	protected $fillable = [
		'entity',
		'email',
		'unsubscribegroup',
		'ip',
		'date_creat',
		'tms'
	];
}
