<?php

use app\db\Migration;

/**
 * Class m210111_235009_create_table_quiz_employee
 */
class m210111_235009_create_table_quiz_employee extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%quiz_employee}}', [
            'quiz_employee_id' => $this->primaryKey(),
            'employee_id' => $this->integer(),
            'quiz_id' => $this->integer(),
            'token' => $this->string(),
            'passed' => $this->boolean()->notNull()->defaultValue(0),
            'start_date' => $this->integer(),
            'end_date' => $this->integer(),
            'score' => $this->integer()->notNull()->defaultValue(0),
            'current_level' => $this->integer()->notNull()->defaultValue(1),
            'show_explanation' => $this->boolean()->notNull()->defaultValue(0)
        ], $this->tableOptions);

        $this->addForeignKey(
            'fk-quiz_employee-employee_id',
            'quiz_employee',
            'employee_id',
            'employee',
            'employee_id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-quiz_employee-quiz_id',
            'quiz_employee',
            'quiz_id',
            'quiz',
            'quiz_id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%quiz_employee}}');
    }
}
