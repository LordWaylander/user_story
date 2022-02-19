<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id_reponse
 * @property integer $question_id
 * @property string $reponse
 * @property string $date_reponse
 * @property string $created_at
 * @property string $updated_at
 * @property Question $question
 */
class Reponse extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reponses';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_reponse';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['question_id', 'reponse', 'date_reponse', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->hasOne(Question::class, 'id_question', 'question_id');
    }
}
