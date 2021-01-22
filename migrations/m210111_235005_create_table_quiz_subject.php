<?php

use app\db\Migration;

/**
 * Class m210111_235005_create_table_quiz_subject
 */
class m210111_235005_create_table_quiz_subject extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%quiz_subject}}', [
            'quiz_subject_id' => $this->primaryKey(),
            'name' => $this->string()
        ], $this->tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%quiz_subject}}');
    }
}
