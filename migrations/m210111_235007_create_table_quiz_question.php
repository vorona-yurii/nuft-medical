<?php

use app\db\Migration;

/**
 * Class m210111_235007_create_table_quiz_question
 */
class m210111_235007_create_table_quiz_question extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%quiz_question}}', [
            'quiz_question_id' => $this->primaryKey(),
            'quiz_subject_id' => $this->integer(),
            'level' => $this->integer(),
            'type' => "ENUM('simple', 'multiple')",
            'image' => $this->text(),
            'content' => $this->text(),
            'explanation' => $this->text(),
            'references' => $this->json()
        ], $this->tableOptions);

        $this->addForeignKey(
            'fk-quiz_question-quiz_subject_id',
            'quiz_question',
            'quiz_subject_id',
            'quiz_subject',
            'quiz_subject_id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%quiz_question}}');
    }
}
