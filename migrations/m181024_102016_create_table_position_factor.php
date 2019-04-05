<?php

use app\db\Migration;

/**
 * Class m181024_102016_create_table_position_factor
 */
class m181024_102016_create_table_position_factor extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->createTable( '{{%position_factor}}', [
            'position_factor_id' => $this->primaryKey(),
            'position_id'        => $this->integer(),
            'factor_id'          => $this->integer()
        ], $this->tableOptions );

        $this->addForeignKey(
            'fk-position_factor-position_id',
            'position_factor',
            'position_id',
            'position',
            'position_id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-position_factor-factor_id',
            'position_factor',
            'factor_id',
            'factor',
            'factor_id',
            'CASCADE'
        );
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable( '{{%position_factor}}' );
    }
}
