<?php

use app\db\Migration;

/**
 * Class m210111_235010_create_table_quiz_employee_answer
 */
class m210111_235010_create_table_quiz_employee_answer extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%quiz_employee_answer}}', [
            'quiz_employee_answer_id' => $this->primaryKey(),
            'quiz_employee_id' => $this->integer(),
            'quiz_answer_id' => $this->integer(),
        ], $this->tableOptions);

        $this->addForeignKey(
            'fk-quiz_employee_answer-quiz_employee_id',
            'quiz_employee_answer',
            'quiz_employee_id',
            'quiz_employee',
            'quiz_employee_id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-quiz_employee_answer-quiz_answer_id',
            'quiz_employee_answer',
            'quiz_answer_id',
            'quiz_answer',
            'quiz_answer_id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%quiz_employee_answer}}');
    }
}
