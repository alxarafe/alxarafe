<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCategorieTicket
 *
 * @property int $fk_categorie
 * @property int $fk_ticket
 * @property string|null $import_key
 *
 * @property LlxCategorie $llx_categorie
 * @property LlxTicket $llx_ticket
 *
 * @package App\Models
 */
class LlxCategorieTicket extends Model
{
	protected $table = 'llx_categorie_ticket';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'fk_categorie' => 'int',
		'fk_ticket' => 'int'
	];

	protected $fillable = [
		'import_key'
	];

	public function llx_categorie()
	{
		return $this->belongsTo(LlxCategorie::class, 'fk_categorie');
	}

	public function llx_ticket()
	{
		return $this->belongsTo(LlxTicket::class, 'fk_ticket');
	}
}
