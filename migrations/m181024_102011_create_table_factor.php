<?php

use app\db\Migration;

/**
 * Class m181024_102011_create_table_factor
 */
class m181024_102011_create_table_factor extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->createTable( '{{%factor}}', [
            'factor_id'   => $this->primaryKey(),
            'name'        => $this->string(),
            'code'        => $this->string()
        ], $this->tableOptions );
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable( '{{%factor}}' );
    }
}
