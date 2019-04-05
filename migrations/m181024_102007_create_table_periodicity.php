<?php

use app\db\Migration;

/**
 * Class m181024_102007_create_table_periodicity
 */
class m181024_102007_create_table_periodicity extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->createTable( '{{%periodicity}}', [
            'periodicity_id'  => $this->primaryKey(),
            'name'            => $this->string()
        ], $this->tableOptions );
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable( '{{%periodicity}}' );
    }
}
