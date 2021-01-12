<?php

use app\db\Migration;

/**
 * Class m210111_235008_create_table_quiz_answer
 */
class m210111_235008_create_table_quiz_answer extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%quiz_answer}}', [
            'quiz_answer_id' => $this->primaryKey(),
            'quiz_question_id' => $this->integer(),
            'content' => $this->text(),
            'correct' => $this->boolean()->notNull()->defaultValue(0)
        ], $this->tableOptions);

        $this->addForeignKey(
            'fk-quiz_answer-quiz_question_id',
            'quiz_answer',
            'quiz_question_id',
            'quiz_question',
            'quiz_question_id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%quiz_answer}}');
    }
}
