<?php

use app\db\Migration;

/**
 * Class m181024_102008_create_table_profession_doctor
 */
class m181024_102008_create_table_profession_doctor extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->createTable( '{{%profession_doctor}}', [
            'profession_doctor_id'  => $this->primaryKey(),
            'profession_id'         => $this->integer(),
            'doctor_id'             => $this->integer()
        ], $this->tableOptions );

        $this->addForeignKey(
            'fk-profession_doctor-profession_id',
            'profession_doctor',
            'profession_id',
            'profession',
            'profession_id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-profession_doctor-doctor_id',
            'profession_doctor',
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
        $this->dropTable( '{{%profession_doctor}}' );
    }
}
