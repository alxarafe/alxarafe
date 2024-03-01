<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxAdherentTypeLang
 *
 * @property int $rowid
 * @property int $fk_type
 * @property string $lang
 * @property string $label
 * @property string|null $description
 * @property string|null $email
 * @property string|null $import_key
 *
 * @package App\Models
 */
class LlxAdherentTypeLang extends Model
{
	protected $table = 'llx_adherent_type_lang';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_type' => 'int'
	];

	protected $fillable = [
		'fk_type',
		'lang',
		'label',
		'description',
		'email',
		'import_key'
	];
}
