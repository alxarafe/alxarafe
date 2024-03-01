<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxSocieteAccount
 *
 * @property int $rowid
 * @property int|null $entity
 * @property string $login
 * @property string|null $pass_encoding
 * @property string|null $pass_crypted
 * @property string|null $pass_temp
 * @property int|null $fk_soc
 * @property int|null $fk_website
 * @property string $site
 * @property string|null $site_account
 * @property string|null $key_account
 * @property string|null $note_private
 * @property Carbon|null $date_last_login
 * @property Carbon|null $date_previous_login
 * @property Carbon $date_creation
 * @property Carbon|null $tms
 * @property int $fk_user_creat
 * @property int|null $fk_user_modif
 * @property string|null $import_key
 * @property int|null $status
 *
 * @property LlxSociete|null $llx_societe
 *
 * @package App\Models
 */
class LlxSocieteAccount extends Model
{
	protected $table = 'llx_societe_account';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_soc' => 'int',
		'fk_website' => 'int',
		'date_last_login' => 'datetime',
		'date_previous_login' => 'datetime',
		'date_creation' => 'datetime',
		'tms' => 'datetime',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'entity',
		'login',
		'pass_encoding',
		'pass_crypted',
		'pass_temp',
		'fk_soc',
		'fk_website',
		'site',
		'site_account',
		'key_account',
		'note_private',
		'date_last_login',
		'date_previous_login',
		'date_creation',
		'tms',
		'fk_user_creat',
		'fk_user_modif',
		'import_key',
		'status'
	];

	public function llx_societe()
	{
		return $this->belongsTo(LlxSociete::class, 'fk_soc');
	}
}
