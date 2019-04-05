<?php

use app\db\Migration;

/**
 * Class m181024_102004_create_table_profession
 */
class m181024_102004_create_table_profession extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->createTable( '{{%profession}}', [
            'profession_id'  => $this->primaryKey(),
            'name'           => $this->string(),
            'code'           => $this->string()
        ], $this->tableOptions );
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable( '{{%profession}}' );
    }
}
