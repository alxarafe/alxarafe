<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxElementContact
 *
 * @property int $rowid
 * @property Carbon|null $datecreate
 * @property int|null $statut
 * @property int $element_id
 * @property int $fk_c_type_contact
 * @property int $fk_socpeople
 *
 * @property LlxCTypeContact $llx_c_type_contact
 *
 * @package App\Models
 */
class LlxElementContact extends Model
{
	protected $table = 'llx_element_contact';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'datecreate' => 'datetime',
		'statut' => 'int',
		'element_id' => 'int',
		'fk_c_type_contact' => 'int',
		'fk_socpeople' => 'int'
	];

	protected $fillable = [
		'datecreate',
		'statut',
		'element_id',
		'fk_c_type_contact',
		'fk_socpeople'
	];

	public function llx_c_type_contact()
	{
		return $this->belongsTo(LlxCTypeContact::class, 'fk_c_type_contact');
	}
}
