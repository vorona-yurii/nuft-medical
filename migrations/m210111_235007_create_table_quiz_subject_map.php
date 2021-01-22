<?php

use app\db\Migration;

/**
 * Class m210111_235007_create_table_quiz_subject_map
 */
class m210111_235007_create_table_quiz_subject_map extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%quiz_subject_map}}', [
            'quiz_id' => $this->integer(),
            'quiz_subject_id' => $this->integer(),
        ], $this->tableOptions);

        $this->addPrimaryKey(
            'pk-quiz_subject_map-quiz_id-quiz_subject_id',
            'quiz_subject_map',
            ['quiz_id', 'quiz_subject_id']
        );

        $this->addForeignKey(
            'fk-quiz_subject_map-quiz_id-quiz_id',
            'quiz_subject_map',
            'quiz_id',
            'quiz',
            'quiz_id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-quiz_subject_map-quiz_subject_id-quiz_subject_id',
            'quiz_subject_map',
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
        $this->dropTable('{{%quiz_subject_map}}');
    }
}
