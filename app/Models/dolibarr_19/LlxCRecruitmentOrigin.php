<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCRecruitmentOrigin
 *
 * @property int $rowid
 * @property string $code
 * @property string $label
 * @property int $active
 *
 * @package App\Models
 */
class LlxCRecruitmentOrigin extends Model
{
	protected $table = 'llx_c_recruitment_origin';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'active' => 'int'
	];

	protected $fillable = [
		'code',
		'label',
		'active'
	];
}
