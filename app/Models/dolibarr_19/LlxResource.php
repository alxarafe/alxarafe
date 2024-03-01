<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxResource
 *
 * @property int $rowid
 * @property int $entity
 * @property string|null $ref
 * @property string|null $asset_number
 * @property string|null $description
 * @property string|null $fk_code_type_resource
 * @property string|null $address
 * @property string|null $zip
 * @property string|null $town
 * @property string|null $photo_filename
 * @property int|null $max_users
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $url
 * @property Carbon|null $datec
 * @property Carbon|null $date_valid
 * @property int|null $fk_user_author
 * @property int|null $fk_user_modif
 * @property int|null $fk_user_valid
 * @property int $fk_statut
 * @property string|null $note_public
 * @property string|null $note_private
 * @property string|null $import_key
 * @property string|null $extraparams
 * @property int|null $fk_country
 * @property int|null $fk_state
 * @property Carbon|null $tms
 *
 * @property LlxCCountry|null $llx_c_country
 *
 * @package App\Models
 */
class LlxResource extends Model
{
	protected $table = 'llx_resource';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'max_users' => 'int',
		'datec' => 'datetime',
		'date_valid' => 'datetime',
		'fk_user_author' => 'int',
		'fk_user_modif' => 'int',
		'fk_user_valid' => 'int',
		'fk_statut' => 'int',
		'fk_country' => 'int',
		'fk_state' => 'int',
		'tms' => 'datetime'
	];

	protected $fillable = [
		'entity',
		'ref',
		'asset_number',
		'description',
		'fk_code_type_resource',
		'address',
		'zip',
		'town',
		'photo_filename',
		'max_users',
		'phone',
		'email',
		'url',
		'datec',
		'date_valid',
		'fk_user_author',
		'fk_user_modif',
		'fk_user_valid',
		'fk_statut',
		'note_public',
		'note_private',
		'import_key',
		'extraparams',
		'fk_country',
		'fk_state',
		'tms'
	];

	public function llx_c_country()
	{
		return $this->belongsTo(LlxCCountry::class, 'fk_country');
	}
}
