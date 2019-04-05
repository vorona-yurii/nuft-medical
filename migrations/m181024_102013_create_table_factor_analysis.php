<?php

use app\db\Migration;

/**
 * Class m181024_102013_create_table_profession_analysis
 */
class m181024_102013_create_table_factor_analysis extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->createTable( '{{%factor_analysis}}', [
            'factor_analysis_id' => $this->primaryKey(),
            'factor_id'          => $this->integer(),
            'analysis_id'        => $this->integer()
        ], $this->tableOptions );

        $this->addForeignKey(
            'fk-factor_analysis-factor_id',
            'factor_analysis',
            'factor_id',
            'factor',
            'factor_id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-factor_analysis-analysis_id',
            'factor_analysis',
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
        $this->dropTable( '{{%factor_analysis}}' );
    }
}
