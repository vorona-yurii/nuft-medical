<?php

use app\db\Migration;

/**
 * Class m181024_102012_create_table_profession_doctor
 */
class m181024_102012_create_table_factor_doctor extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->createTable( '{{%factor_doctor}}', [
            'factor_doctor_id' => $this->primaryKey(),
            'factor_id'        => $this->integer(),
            'doctor_id'        => $this->integer()
        ], $this->tableOptions );

        $this->addForeignKey(
            'fk-factor_doctor-factor_id',
            'factor_doctor',
            'factor_id',
            'factor',
            'factor_id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-factor_doctor-doctor_id',
            'factor_doctor',
            'doctor_id',
            'doctor',
            'doctor_id',
            'CASCADE'
        );
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable( '{{%factor_doctor}}' );
    }
}
