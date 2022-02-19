<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id_entreprise
 * @property string $nom_entreprise
 * @property string $adresse_entreprise
 * @property int $code_postal
 * @property string $ville
 * @property string $created_at
 * @property string $updated_at
 * @property Client[] $clients
 */
class Entreprise extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'entreprises';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_entreprise';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['nom_entreprise', 'adresse_entreprise', 'code_postal', 'ville', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clients()
    {
        return $this->hasMany(client::class, 'entreprise_id', 'id_entreprise');
    }
}
