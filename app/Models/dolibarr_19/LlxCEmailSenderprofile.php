<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCEmailSenderprofile
 *
 * @property int $rowid
 * @property int $entity
 * @property int $private
 * @property Carbon|null $date_creation
 * @property Carbon|null $tms
 * @property string|null $label
 * @property string $email
 * @property string|null $signature
 * @property int|null $position
 * @property int $active
 *
 * @package App\Models
 */
class LlxCEmailSenderprofile extends Model
{
	protected $table = 'llx_c_email_senderprofile';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'private' => 'int',
		'date_creation' => 'datetime',
		'tms' => 'datetime',
		'position' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'entity',
		'private',
		'date_creation',
		'tms',
		'label',
		'email',
		'signature',
		'position',
		'active'
	];
}
