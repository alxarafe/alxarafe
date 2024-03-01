<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxEmailcollectorEmailcollector
 *
 * @property int $rowid
 * @property int $entity
 * @property string $ref
 * @property string|null $label
 * @property string|null $description
 * @property string|null $host
 * @property string|null $port
 * @property string|null $hostcharset
 * @property string|null $imap_encryption
 * @property int|null $norsh
 * @property string|null $login
 * @property int|null $acces_type
 * @property string|null $oauth_service
 * @property string|null $password
 * @property string $source_directory
 * @property string|null $target_directory
 * @property int|null $maxemailpercollect
 * @property Carbon|null $datelastresult
 * @property string|null $codelastresult
 * @property string|null $lastresult
 * @property Carbon|null $datelastok
 * @property string|null $note_public
 * @property string|null $note_private
 * @property Carbon $date_creation
 * @property Carbon|null $tms
 * @property int $fk_user_creat
 * @property int|null $fk_user_modif
 * @property int $position
 * @property string|null $import_key
 * @property int $status
 *
 * @property Collection|LlxEmailcollectorEmailcollectoraction[] $llx_emailcollector_emailcollectoractions
 * @property Collection|LlxEmailcollectorEmailcollectorfilter[] $llx_emailcollector_emailcollectorfilters
 *
 * @package App\Models
 */
class LlxEmailcollectorEmailcollector extends Model
{
	protected $table = 'llx_emailcollector_emailcollector';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'norsh' => 'int',
		'acces_type' => 'int',
		'maxemailpercollect' => 'int',
		'datelastresult' => 'datetime',
		'datelastok' => 'datetime',
		'date_creation' => 'datetime',
		'tms' => 'datetime',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'position' => 'int',
		'status' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'entity',
		'ref',
		'label',
		'description',
		'host',
		'port',
		'hostcharset',
		'imap_encryption',
		'norsh',
		'login',
		'acces_type',
		'oauth_service',
		'password',
		'source_directory',
		'target_directory',
		'maxemailpercollect',
		'datelastresult',
		'codelastresult',
		'lastresult',
		'datelastok',
		'note_public',
		'note_private',
		'date_creation',
		'tms',
		'fk_user_creat',
		'fk_user_modif',
		'position',
		'import_key',
		'status'
	];

	public function llx_emailcollector_emailcollectoractions()
	{
		return $this->hasMany(LlxEmailcollectorEmailcollectoraction::class, 'fk_emailcollector');
	}

	public function llx_emailcollector_emailcollectorfilters()
	{
		return $this->hasMany(LlxEmailcollectorEmailcollectorfilter::class, 'fk_emailcollector');
	}
}
