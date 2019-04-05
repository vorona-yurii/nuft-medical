<?php

use app\db\Migration;

/**
 * Class m181024_102009_create_table_profession_analysis
 */
class m181024_102009_create_table_profession_analysis extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->createTable( '{{%profession_analysis}}', [
            'profession_analysis_id'  => $this->primaryKey(),
            'profession_id'           => $this->integer(),
            'analysis_id'             => $this->integer()
        ], $this->tableOptions );

        $this->addForeignKey(
            'fk-profession_analysis-profession_id',
            'profession_analysis',
            'profession_id',
            'profession',
            'profession_id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-profession_analysis-analysis_id',
            'profession_analysis',
            'analysis_id',
            'analysis',
            'analysis_id',
            'CASCADE'
        );
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable( '{{%profession_analysis}}' );
    }
}
