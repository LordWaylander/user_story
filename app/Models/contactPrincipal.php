<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_contact_principal
 * @property string $nom
 * @property string $prenom
 * @property string $mail
 * @property Client[] $clients
 */
class contactPrincipal extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contacts';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_contact_principal';

    /**
     * @var array
     */
    protected $fillable = ['nom', 'mail'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clients()
    {
        return $this->hasMany(client::class, 'contact_principal_id', 'id_contact_principal');
    }
}
