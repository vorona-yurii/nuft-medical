<?php

use app\db\Migration;

/**
 * Class m181024_102014_create_table_factor_periodicity
 */
class m181024_102014_create_table_factor_periodicity extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->createTable( '{{%factor_periodicity}}', [
            'factor_periodicity_id' => $this->primaryKey(),
            'factor_id'             => $this->integer(),
            'periodicity_id'        => $this->integer()
        ], $this->tableOptions );

        $this->addForeignKey(
            'fk-factor_periodicity-factor_id',
            'factor_periodicity',
            'factor_id',
            'factor',
            'factor_id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-factor_periodicity-periodicity_id',
            'factor_periodicity',
            'periodicity_id',
            'periodicity',
            'periodicity_id',
            'CASCADE'
        );
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable( '{{%factor_periodicity}}' );
    }
}
