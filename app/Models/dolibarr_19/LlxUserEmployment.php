<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxUserEmployment
 *
 * @property int $rowid
 * @property int $entity
 * @property string|null $ref
 * @property string|null $ref_ext
 * @property int|null $fk_user
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property int|null $fk_user_creat
 * @property int|null $fk_user_modif
 * @property string|null $job
 * @property int $status
 * @property float|null $salary
 * @property float|null $salaryextra
 * @property float|null $weeklyhours
 * @property Carbon|null $dateemployment
 * @property Carbon|null $dateemploymentend
 *
 * @property LlxUser|null $llx_user
 *
 * @package App\Models
 */
class LlxUserEmployment extends Model
{
	protected $table = 'llx_user_employment';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_user' => 'int',
		'datec' => 'datetime',
		'tms' => 'datetime',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'status' => 'int',
		'salary' => 'float',
		'salaryextra' => 'float',
		'weeklyhours' => 'float',
		'dateemployment' => 'datetime',
		'dateemploymentend' => 'datetime'
	];

	protected $fillable = [
		'entity',
		'ref',
		'ref_ext',
		'fk_user',
		'datec',
		'tms',
		'fk_user_creat',
		'fk_user_modif',
		'job',
		'status',
		'salary',
		'salaryextra',
		'weeklyhours',
		'dateemployment',
		'dateemploymentend'
	];

	public function llx_user()
	{
		return $this->belongsTo(LlxUser::class, 'fk_user');
	}
}
