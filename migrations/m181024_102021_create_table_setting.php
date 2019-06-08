<?php

use app\db\Migration;

/**
 * Class m181024_102021_create_table_settings
 */
class m181024_102021_create_table_setting extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->createTable( '{{%setting}}', [
            'setting_id'  => $this->primaryKey(),
            'key'         => $this->string(),
            'value'       => $this->text()
        ], $this->tableOptions );
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable( '{{%setting}}' );
    }
}
