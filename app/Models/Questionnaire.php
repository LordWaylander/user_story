<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id_questionnaire
 * @property string $nom_questionnaire
 * @property string $description
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property Question[] $questions
 * @property RelationQuestionnaireClient[] $relationQuestionnaireClients
 */
class Questionnaire extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'questionnaires';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_questionnaire';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['nom_questionnaire', 'description', 'status', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class, 'id_questionnaire', 'id_questionnaire');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function relationQuestionnaireClients()
    {
        return $this->hasMany(relationQuestionnaireClient::class, 'questionnaire_id', 'id_questionnaire');
    }
}
