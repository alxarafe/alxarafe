<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxSocperson
 *
 * @property int $rowid
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property int|null $fk_soc
 * @property int $entity
 * @property string|null $ref_ext
 * @property string|null $civility
 * @property string|null $lastname
 * @property string|null $firstname
 * @property string|null $address
 * @property string|null $zip
 * @property string|null $town
 * @property int|null $fk_departement
 * @property int|null $fk_pays
 * @property Carbon|null $birthday
 * @property string|null $poste
 * @property string|null $phone
 * @property string|null $phone_perso
 * @property string|null $phone_mobile
 * @property string|null $fax
 * @property string|null $email
 * @property string|null $socialnetworks
 * @property string|null $photo
 * @property int $no_email
 * @property int $priv
 * @property string|null $fk_prospectlevel
 * @property int $fk_stcommcontact
 * @property int|null $fk_user_creat
 * @property int|null $fk_user_modif
 * @property string|null $note_private
 * @property string|null $note_public
 * @property string|null $default_lang
 * @property string|null $canvas
 * @property string|null $import_key
 * @property int $statut
 *
 * @property LlxSociete|null $llx_societe
 * @property LlxUser|null $llx_user
 * @property Collection|LlxCategorieContact[] $llx_categorie_contacts
 * @property Collection|LlxSocieteContact[] $llx_societe_contacts
 *
 * @package App\Models
 */
class LlxSocperson extends Model
{
	protected $table = 'llx_socpeople';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'datec' => 'datetime',
		'tms' => 'datetime',
		'fk_soc' => 'int',
		'entity' => 'int',
		'fk_departement' => 'int',
		'fk_pays' => 'int',
		'birthday' => 'datetime',
		'no_email' => 'int',
		'priv' => 'int',
		'fk_stcommcontact' => 'int',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'statut' => 'int'
	];

	protected $fillable = [
		'datec',
		'tms',
		'fk_soc',
		'entity',
		'ref_ext',
		'civility',
		'lastname',
		'firstname',
		'address',
		'zip',
		'town',
		'fk_departement',
		'fk_pays',
		'birthday',
		'poste',
		'phone',
		'phone_perso',
		'phone_mobile',
		'fax',
		'email',
		'socialnetworks',
		'photo',
		'no_email',
		'priv',
		'fk_prospectlevel',
		'fk_stcommcontact',
		'fk_user_creat',
		'fk_user_modif',
		'note_private',
		'note_public',
		'default_lang',
		'canvas',
		'import_key',
		'statut'
	];

	public function llx_societe()
	{
		return $this->belongsTo(LlxSociete::class, 'fk_soc');
	}

	public function llx_user()
	{
		return $this->belongsTo(LlxUser::class, 'fk_user_creat');
	}

	public function llx_categorie_contacts()
	{
		return $this->hasMany(LlxCategorieContact::class, 'fk_socpeople');
	}

	public function llx_societe_contacts()
	{
		return $this->hasMany(LlxSocieteContact::class, 'fk_socpeople');
	}
}
