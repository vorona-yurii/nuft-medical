<?php

use app\db\Migration;

/**
 * Class m210111_235006_create_table_quiz
 */
class m210111_235006_create_table_quiz extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%quiz}}', [
            'quiz_id' => $this->primaryKey(),
            'name' => $this->string(),
            'description' => $this->text(),
            'duration' => $this->integer()
        ], $this->tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%quiz}}');
    }
}
