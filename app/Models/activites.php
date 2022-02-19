<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_activites
 * @property string $type_activite
 * @property string $type_entite
 * @property string $nom_entite
 * @property string $created_at
 * @property string $updated_at
 */
class activites extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'activites';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_activites';

    /**
     * @var array
     */
    protected $fillable = ['type_activite', 'type_entite', 'nom_entite', 'created_at', 'updated_at'];

}
