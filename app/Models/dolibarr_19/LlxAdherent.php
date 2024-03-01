<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxAdherent
 *
 * @property int $rowid
 * @property string $ref
 * @property int $entity
 * @property string|null $ref_ext
 * @property string|null $gender
 * @property string|null $civility
 * @property string|null $lastname
 * @property string|null $firstname
 * @property string|null $login
 * @property string|null $pass
 * @property string|null $pass_crypted
 * @property int $fk_adherent_type
 * @property string $morphy
 * @property string|null $societe
 * @property int|null $fk_soc
 * @property string|null $address
 * @property string|null $zip
 * @property string|null $town
 * @property int|null $state_id
 * @property int|null $country
 * @property string|null $email
 * @property string|null $url
 * @property string|null $socialnetworks
 * @property string|null $phone
 * @property string|null $phone_perso
 * @property string|null $phone_mobile
 * @property Carbon|null $birth
 * @property string|null $photo
 * @property int $statut
 * @property int $public
 * @property Carbon|null $datefin
 * @property string|null $default_lang
 * @property string|null $note_private
 * @property string|null $note_public
 * @property string|null $model_pdf
 * @property Carbon|null $datevalid
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property int|null $fk_user_author
 * @property int|null $fk_user_mod
 * @property int|null $fk_user_valid
 * @property string|null $canvas
 * @property string|null $ip
 * @property string|null $import_key
 *
 * @property LlxSociete|null $llx_societe
 * @property LlxAdherentType $llx_adherent_type
 * @property Collection|LlxCategorieMember[] $llx_categorie_members
 *
 * @package App\Models
 */
class LlxAdherent extends Model
{
	protected $table = 'llx_adherent';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_adherent_type' => 'int',
		'fk_soc' => 'int',
		'state_id' => 'int',
		'country' => 'int',
		'birth' => 'datetime',
		'statut' => 'int',
		'public' => 'int',
		'datefin' => 'datetime',
		'datevalid' => 'datetime',
		'datec' => 'datetime',
		'tms' => 'datetime',
		'fk_user_author' => 'int',
		'fk_user_mod' => 'int',
		'fk_user_valid' => 'int'
	];

	protected $fillable = [
		'ref',
		'entity',
		'ref_ext',
		'gender',
		'civility',
		'lastname',
		'firstname',
		'login',
		'pass',
		'pass_crypted',
		'fk_adherent_type',
		'morphy',
		'societe',
		'fk_soc',
		'address',
		'zip',
		'town',
		'state_id',
		'country',
		'email',
		'url',
		'socialnetworks',
		'phone',
		'phone_perso',
		'phone_mobile',
		'birth',
		'photo',
		'statut',
		'public',
		'datefin',
		'default_lang',
		'note_private',
		'note_public',
		'model_pdf',
		'datevalid',
		'datec',
		'tms',
		'fk_user_author',
		'fk_user_mod',
		'fk_user_valid',
		'canvas',
		'ip',
		'import_key'
	];

	public function llx_societe()
	{
		return $this->belongsTo(LlxSociete::class, 'fk_soc');
	}

	public function llx_adherent_type()
	{
		return $this->belongsTo(LlxAdherentType::class, 'fk_adherent_type');
	}

	public function llx_categorie_members()
	{
		return $this->hasMany(LlxCategorieMember::class, 'fk_member');
	}
}
