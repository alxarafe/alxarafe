<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCUnit
 *
 * @property int $rowid
 * @property string|null $code
 * @property int|null $sortorder
 * @property int|null $scale
 * @property string|null $label
 * @property string|null $short_label
 * @property string|null $unit_type
 * @property int $active
 *
 * @property Collection|LlxCommandeFournisseurdet[] $llx_commande_fournisseurdets
 * @property Collection|LlxCommandedet[] $llx_commandedets
 * @property Collection|LlxContratdet[] $llx_contratdets
 * @property Collection|LlxFactureFournDet[] $llx_facture_fourn_dets
 * @property Collection|LlxFactureFournDetRec[] $llx_facture_fourn_det_recs
 * @property Collection|LlxFacturedet[] $llx_facturedets
 * @property Collection|LlxFacturedetRec[] $llx_facturedet_recs
 * @property Collection|LlxProduct[] $llx_products
 * @property Collection|LlxPropaldet[] $llx_propaldets
 * @property Collection|LlxSupplierProposaldet[] $llx_supplier_proposaldets
 *
 * @package App\Models
 */
class LlxCUnit extends Model
{
	protected $table = 'llx_c_units';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'sortorder' => 'int',
		'scale' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'code',
		'sortorder',
		'scale',
		'label',
		'short_label',
		'unit_type',
		'active'
	];

	public function llx_commande_fournisseurdets()
	{
		return $this->hasMany(LlxCommandeFournisseurdet::class, 'fk_unit');
	}

	public function llx_commandedets()
	{
		return $this->hasMany(LlxCommandedet::class, 'fk_unit');
	}

	public function llx_contratdets()
	{
		return $this->hasMany(LlxContratdet::class, 'fk_unit');
	}

	public function llx_facture_fourn_dets()
	{
		return $this->hasMany(LlxFactureFournDet::class, 'fk_unit');
	}

	public function llx_facture_fourn_det_recs()
	{
		return $this->hasMany(LlxFactureFournDetRec::class, 'fk_unit');
	}

	public function llx_facturedets()
	{
		return $this->hasMany(LlxFacturedet::class, 'fk_unit');
	}

	public function llx_facturedet_recs()
	{
		return $this->hasMany(LlxFacturedetRec::class, 'fk_unit');
	}

	public function llx_products()
	{
		return $this->hasMany(LlxProduct::class, 'fk_unit');
	}

	public function llx_propaldets()
	{
		return $this->hasMany(LlxPropaldet::class, 'fk_unit');
	}

	public function llx_supplier_proposaldets()
	{
		return $this->hasMany(LlxSupplierProposaldet::class, 'fk_unit');
	}
}
