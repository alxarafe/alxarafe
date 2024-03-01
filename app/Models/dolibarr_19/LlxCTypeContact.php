<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCTypeContact
 *
 * @property int $rowid
 * @property string $element
 * @property string $source
 * @property string $code
 * @property string $libelle
 * @property int $active
 * @property string|null $module
 * @property int $position
 *
 * @property Collection|LlxElementContact[] $llx_element_contacts
 * @property Collection|LlxSocieteContact[] $llx_societe_contacts
 *
 * @package App\Models
 */
class LlxCTypeContact extends Model
{
	protected $table = 'llx_c_type_contact';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'active' => 'int',
		'position' => 'int'
	];

	protected $fillable = [
		'element',
		'source',
		'code',
		'libelle',
		'active',
		'module',
		'position'
	];

	public function llx_element_contacts()
	{
		return $this->hasMany(LlxElementContact::class, 'fk_c_type_contact');
	}

	public function llx_societe_contacts()
	{
		return $this->hasMany(LlxSocieteContact::class, 'fk_c_type_contact');
	}
}
