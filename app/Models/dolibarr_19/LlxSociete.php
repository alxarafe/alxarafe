<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxSociete
 *
 * @property int $rowid
 * @property string|null $nom
 * @property string|null $name_alias
 * @property int $entity
 * @property string|null $ref_ext
 * @property int|null $statut
 * @property int|null $parent
 * @property int|null $status
 * @property string|null $code_client
 * @property string|null $code_fournisseur
 * @property string|null $code_compta
 * @property string|null $code_compta_fournisseur
 * @property string|null $address
 * @property string|null $zip
 * @property string|null $town
 * @property int|null $fk_departement
 * @property int|null $fk_pays
 * @property int|null $fk_account
 * @property string|null $phone
 * @property string|null $fax
 * @property string|null $url
 * @property string|null $email
 * @property string|null $socialnetworks
 * @property int|null $fk_effectif
 * @property int|null $fk_typent
 * @property int|null $fk_forme_juridique
 * @property string|null $fk_currency
 * @property string|null $siren
 * @property string|null $siret
 * @property string|null $ape
 * @property string|null $idprof4
 * @property string|null $idprof5
 * @property string|null $idprof6
 * @property string|null $tva_intra
 * @property float|null $capital
 * @property int $fk_stcomm
 * @property string|null $note_private
 * @property string|null $note_public
 * @property string|null $model_pdf
 * @property string|null $last_main_doc
 * @property string|null $prefix_comm
 * @property int|null $client
 * @property int|null $fournisseur
 * @property string|null $supplier_account
 * @property string|null $fk_prospectlevel
 * @property int|null $fk_incoterms
 * @property string|null $location_incoterms
 * @property int|null $customer_bad
 * @property float|null $customer_rate
 * @property float|null $supplier_rate
 * @property float|null $remise_client
 * @property float|null $remise_supplier
 * @property int|null $mode_reglement
 * @property int|null $cond_reglement
 * @property string|null $deposit_percent
 * @property int|null $transport_mode
 * @property int|null $mode_reglement_supplier
 * @property int|null $cond_reglement_supplier
 * @property int|null $transport_mode_supplier
 * @property int|null $fk_shipping_method
 * @property int|null $tva_assuj
 * @property int|null $vat_reverse_charge
 * @property int|null $localtax1_assuj
 * @property float|null $localtax1_value
 * @property int|null $localtax2_assuj
 * @property float|null $localtax2_value
 * @property string|null $barcode
 * @property int|null $fk_barcode_type
 * @property int|null $price_level
 * @property float|null $outstanding_limit
 * @property float|null $order_min_amount
 * @property float|null $supplier_order_min_amount
 * @property string|null $default_lang
 * @property string|null $logo
 * @property string|null $logo_squarred
 * @property string|null $canvas
 * @property int|null $fk_warehouse
 * @property string|null $webservices_url
 * @property string|null $webservices_key
 * @property string|null $accountancy_code_sell
 * @property string|null $accountancy_code_buy
 * @property Carbon|null $tms
 * @property Carbon|null $datec
 * @property int|null $fk_user_creat
 * @property int|null $fk_user_modif
 * @property int|null $fk_multicurrency
 * @property string|null $multicurrency_code
 * @property string|null $import_key
 *
 * @property LlxAdherent $llx_adherent
 * @property Collection|LlxCategorieFournisseur[] $llx_categorie_fournisseurs
 * @property Collection|LlxCategorieSociete[] $llx_categorie_societes
 * @property Collection|LlxCommande[] $llx_commandes
 * @property Collection|LlxCommandeFournisseur[] $llx_commande_fournisseurs
 * @property Collection|LlxContrat[] $llx_contrats
 * @property Collection|LlxDelivery[] $llx_deliveries
 * @property Collection|LlxExpedition[] $llx_expeditions
 * @property Collection|LlxFacture[] $llx_factures
 * @property Collection|LlxFactureFourn[] $llx_facture_fourns
 * @property Collection|LlxFactureFournRec[] $llx_facture_fourn_recs
 * @property Collection|LlxFactureRec[] $llx_facture_recs
 * @property Collection|LlxFichinter[] $llx_fichinters
 * @property Collection|LlxProductCustomerPrice[] $llx_product_customer_prices
 * @property Collection|LlxProjet[] $llx_projets
 * @property Collection|LlxPropal[] $llx_propals
 * @property Collection|LlxReception[] $llx_receptions
 * @property Collection|LlxSocieteAccount[] $llx_societe_accounts
 * @property Collection|LlxSocieteContact[] $llx_societe_contacts
 * @property Collection|LlxSocieteRemiseExcept[] $llx_societe_remise_excepts
 * @property Collection|LlxSocieteRib[] $llx_societe_ribs
 * @property Collection|LlxSocperson[] $llx_socpeople
 *
 * @package App\Models
 */
class LlxSociete extends Model
{
	protected $table = 'llx_societe';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'statut' => 'int',
		'parent' => 'int',
		'status' => 'int',
		'fk_departement' => 'int',
		'fk_pays' => 'int',
		'fk_account' => 'int',
		'fk_effectif' => 'int',
		'fk_typent' => 'int',
		'fk_forme_juridique' => 'int',
		'capital' => 'float',
		'fk_stcomm' => 'int',
		'client' => 'int',
		'fournisseur' => 'int',
		'fk_incoterms' => 'int',
		'customer_bad' => 'int',
		'customer_rate' => 'float',
		'supplier_rate' => 'float',
		'remise_client' => 'float',
		'remise_supplier' => 'float',
		'mode_reglement' => 'int',
		'cond_reglement' => 'int',
		'transport_mode' => 'int',
		'mode_reglement_supplier' => 'int',
		'cond_reglement_supplier' => 'int',
		'transport_mode_supplier' => 'int',
		'fk_shipping_method' => 'int',
		'tva_assuj' => 'int',
		'vat_reverse_charge' => 'int',
		'localtax1_assuj' => 'int',
		'localtax1_value' => 'float',
		'localtax2_assuj' => 'int',
		'localtax2_value' => 'float',
		'fk_barcode_type' => 'int',
		'price_level' => 'int',
		'outstanding_limit' => 'float',
		'order_min_amount' => 'float',
		'supplier_order_min_amount' => 'float',
		'fk_warehouse' => 'int',
		'tms' => 'datetime',
		'datec' => 'datetime',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'fk_multicurrency' => 'int'
	];

	protected $fillable = [
		'nom',
		'name_alias',
		'entity',
		'ref_ext',
		'statut',
		'parent',
		'status',
		'code_client',
		'code_fournisseur',
		'code_compta',
		'code_compta_fournisseur',
		'address',
		'zip',
		'town',
		'fk_departement',
		'fk_pays',
		'fk_account',
		'phone',
		'fax',
		'url',
		'email',
		'socialnetworks',
		'fk_effectif',
		'fk_typent',
		'fk_forme_juridique',
		'fk_currency',
		'siren',
		'siret',
		'ape',
		'idprof4',
		'idprof5',
		'idprof6',
		'tva_intra',
		'capital',
		'fk_stcomm',
		'note_private',
		'note_public',
		'model_pdf',
		'last_main_doc',
		'prefix_comm',
		'client',
		'fournisseur',
		'supplier_account',
		'fk_prospectlevel',
		'fk_incoterms',
		'location_incoterms',
		'customer_bad',
		'customer_rate',
		'supplier_rate',
		'remise_client',
		'remise_supplier',
		'mode_reglement',
		'cond_reglement',
		'deposit_percent',
		'transport_mode',
		'mode_reglement_supplier',
		'cond_reglement_supplier',
		'transport_mode_supplier',
		'fk_shipping_method',
		'tva_assuj',
		'vat_reverse_charge',
		'localtax1_assuj',
		'localtax1_value',
		'localtax2_assuj',
		'localtax2_value',
		'barcode',
		'fk_barcode_type',
		'price_level',
		'outstanding_limit',
		'order_min_amount',
		'supplier_order_min_amount',
		'default_lang',
		'logo',
		'logo_squarred',
		'canvas',
		'fk_warehouse',
		'webservices_url',
		'webservices_key',
		'accountancy_code_sell',
		'accountancy_code_buy',
		'tms',
		'datec',
		'fk_user_creat',
		'fk_user_modif',
		'fk_multicurrency',
		'multicurrency_code',
		'import_key'
	];

	public function llx_adherent()
	{
		return $this->hasOne(LlxAdherent::class, 'fk_soc');
	}

	public function llx_categorie_fournisseurs()
	{
		return $this->hasMany(LlxCategorieFournisseur::class, 'fk_soc');
	}

	public function llx_categorie_societes()
	{
		return $this->hasMany(LlxCategorieSociete::class, 'fk_soc');
	}

	public function llx_commandes()
	{
		return $this->hasMany(LlxCommande::class, 'fk_soc');
	}

	public function llx_commande_fournisseurs()
	{
		return $this->hasMany(LlxCommandeFournisseur::class, 'fk_soc');
	}

	public function llx_contrats()
	{
		return $this->hasMany(LlxContrat::class, 'fk_soc');
	}

	public function llx_deliveries()
	{
		return $this->hasMany(LlxDelivery::class, 'fk_soc');
	}

	public function llx_expeditions()
	{
		return $this->hasMany(LlxExpedition::class, 'fk_soc');
	}

	public function llx_factures()
	{
		return $this->hasMany(LlxFacture::class, 'fk_soc');
	}

	public function llx_facture_fourns()
	{
		return $this->hasMany(LlxFactureFourn::class, 'fk_soc');
	}

	public function llx_facture_fourn_recs()
	{
		return $this->hasMany(LlxFactureFournRec::class, 'fk_soc');
	}

	public function llx_facture_recs()
	{
		return $this->hasMany(LlxFactureRec::class, 'fk_soc');
	}

	public function llx_fichinters()
	{
		return $this->hasMany(LlxFichinter::class, 'fk_soc');
	}

	public function llx_product_customer_prices()
	{
		return $this->hasMany(LlxProductCustomerPrice::class, 'fk_soc');
	}

	public function llx_projets()
	{
		return $this->hasMany(LlxProjet::class, 'fk_soc');
	}

	public function llx_propals()
	{
		return $this->hasMany(LlxPropal::class, 'fk_soc');
	}

	public function llx_receptions()
	{
		return $this->hasMany(LlxReception::class, 'fk_soc');
	}

	public function llx_societe_accounts()
	{
		return $this->hasMany(LlxSocieteAccount::class, 'fk_soc');
	}

	public function llx_societe_contacts()
	{
		return $this->hasMany(LlxSocieteContact::class, 'fk_soc');
	}

	public function llx_societe_remise_excepts()
	{
		return $this->hasMany(LlxSocieteRemiseExcept::class, 'fk_soc');
	}

	public function llx_societe_ribs()
	{
		return $this->hasMany(LlxSocieteRib::class, 'fk_soc');
	}

	public function llx_socpeople()
	{
		return $this->hasMany(LlxSocperson::class, 'fk_soc');
	}
}
