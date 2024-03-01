<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxEcmFile
 *
 * @property int $rowid
 * @property string|null $ref
 * @property string $label
 * @property string|null $share
 * @property string|null $share_pass
 * @property int $entity
 * @property string $filepath
 * @property string $filename
 * @property string|null $src_object_type
 * @property int|null $src_object_id
 * @property string|null $fullpath_orig
 * @property string|null $description
 * @property string|null $keywords
 * @property string|null $cover
 * @property int|null $position
 * @property string|null $gen_or_uploaded
 * @property string|null $extraparams
 * @property Carbon|null $date_c
 * @property Carbon|null $tms
 * @property int|null $fk_user_c
 * @property int|null $fk_user_m
 * @property string|null $note_private
 * @property string|null $note_public
 * @property string|null $acl
 *
 * @package App\Models
 */
class LlxEcmFile extends Model
{
	protected $table = 'llx_ecm_files';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'src_object_id' => 'int',
		'position' => 'int',
		'date_c' => 'datetime',
		'tms' => 'datetime',
		'fk_user_c' => 'int',
		'fk_user_m' => 'int'
	];

	protected $fillable = [
		'ref',
		'label',
		'share',
		'share_pass',
		'entity',
		'filepath',
		'filename',
		'src_object_type',
		'src_object_id',
		'fullpath_orig',
		'description',
		'keywords',
		'cover',
		'position',
		'gen_or_uploaded',
		'extraparams',
		'date_c',
		'tms',
		'fk_user_c',
		'fk_user_m',
		'note_private',
		'note_public',
		'acl'
	];
}
