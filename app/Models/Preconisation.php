<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id_preconisation
 * @property integer $question_id
 * @property integer $note_reponse
 * @property string $type_reponse
 * @property string $conseil
 * @property string $created_at
 * @property string $updated_at
 * @property Question $question
 */
class Preconisation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'preconisations';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_preconisation';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['question_id', 'note_reponse', 'type_reponse', 'conseil', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasmany
     */
    public function question()
    {
        return $this->hasmany(Question::class, 'question_id', 'id_question');
    }
}
