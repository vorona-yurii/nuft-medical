<?php

use app\db\Migration;

/**
 * Class m181024_102005_create_table_doctor
 */
class m181024_102005_create_table_doctor extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->createTable( '{{%doctor}}', [
            'doctor_id'  => $this->primaryKey(),
            'name'       => $this->string()
        ], $this->tableOptions );
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable( '{{%doctor}}' );
    }
}
