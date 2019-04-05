<?php

use app\db\Migration;

/**
 * Class m181024_102006_create_table_analysis
 */
class m181024_102006_create_table_analysis extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->createTable( '{{%analysis}}', [
            'analysis_id'  => $this->primaryKey(),
            'name'         => $this->string()
        ], $this->tableOptions );
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable( '{{%analysis}}' );
    }
}
