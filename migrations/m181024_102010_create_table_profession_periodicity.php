<?php

use app\db\Migration;

/**
 * Class m181024_102010_create_table_profession_periodicity
 */
class m181024_102010_create_table_profession_periodicity extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->createTable( '{{%profession_periodicity}}', [
            'profession_periodicity_id'  => $this->primaryKey(),
            'profession_id'              => $this->integer(),
            'periodicity_id'             => $this->integer()
        ], $this->tableOptions );

        $this->addForeignKey(
            'fk-profession_periodicity-profession_id',
            'profession_periodicity',
            'profession_id',
            'profession',
            'profession_id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-profession_periodicity-periodicity_id',
            'profession_periodicity',
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
        $this->dropTable( '{{%profession_periodicity}}' );
    }
}
