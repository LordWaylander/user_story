<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id_question
 * @property integer $id_questionnaire
 * @property string $question
 * @property string $created_at
 * @property string $updated_at
 * @property Questionnaire $questionnaire
 * @property Reponse[] $reponses
 */
class Question extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'questions';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_question';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['id_questionnaire', 'question', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class, 'id_questionnaire', 'id_questionnaire');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reponses()
    {
        return $this->hasmany(Reponse::class, 'question_id', 'id_question');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function preconisation()
    {
        return $this->hasmany(Preconisation::class, 'question_id', 'id_question');
    }
}
