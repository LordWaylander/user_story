<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id_client
 * @property integer $entreprise_id
 * @property integer $contact_principal_id
 * @property string $nom
 * @property string $mail
 * @property string $telephone
 * @property int $status
 * @property string $logo
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property Entreprise $entreprise
 * @property RelationClientCompteUser[] $relationClientCompteUsers
 * @property RelationQuestionnaireClient[] $relationQuestionnaireClients
 */
class client extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'clients';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_client';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['entreprise_id', 'contact_principal_id', 'nom', 'mail', 'telephone', 'status', 'logo', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contactPrincipal()
    {
        return $this->belongsTo(User::class, 'contact_principal_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entreprise()
    {
        return $this->hasOne(Entreprise::class, 'id_entreprise','entreprise_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function relationClientCompteUsers()
    {
        return $this->hasOne(RelationCompteUsers::class, 'client_id', 'id_client');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function relationQuestionnaireClients()
    {
        return $this->hasMany(relationQuestionnaireClient::class, 'client_id', 'id_client');
    }
}
