<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $questionnaire_id
 * @property integer $client_id
 * @property string $created_at
 * @property string $updated_at
 * @property Client $client
 * @property Questionnaire $questionnaire
 */
class relationQuestionnaireClient extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'relation_questionnaire_client';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['questionnaire_id', 'client_id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(client::class, 'client_id', 'id_client');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class, 'questionnaire_id', 'id_questionnaire');
    }
}
