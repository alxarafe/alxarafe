<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxSocieteContact
 *
 * @property int $rowid
 * @property int $entity
 * @property Carbon $date_creation
 * @property int $fk_soc
 * @property int $fk_c_type_contact
 * @property int $fk_socpeople
 * @property Carbon|null $tms
 * @property string|null $import_key
 *
 * @property LlxCTypeContact $llx_c_type_contact
 * @property LlxSociete $llx_societe
 * @property LlxSocperson $llx_socperson
 *
 * @package App\Models
 */
class LlxSocieteContact extends Model
{
	protected $table = 'llx_societe_contacts';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'date_creation' => 'datetime',
		'fk_soc' => 'int',
		'fk_c_type_contact' => 'int',
		'fk_socpeople' => 'int',
		'tms' => 'datetime'
	];

	protected $fillable = [
		'entity',
		'date_creation',
		'fk_soc',
		'fk_c_type_contact',
		'fk_socpeople',
		'tms',
		'import_key'
	];

	public function llx_c_type_contact()
	{
		return $this->belongsTo(LlxCTypeContact::class, 'fk_c_type_contact');
	}

	public function llx_societe()
	{
		return $this->belongsTo(LlxSociete::class, 'fk_soc');
	}

	public function llx_socperson()
	{
		return $this->belongsTo(LlxSocperson::class, 'fk_socpeople');
	}
}
