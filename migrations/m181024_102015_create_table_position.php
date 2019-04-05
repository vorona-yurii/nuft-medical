<?php

use app\db\Migration;

/**
 * Class m181024_102015_create_table_position
 */
class m181024_102015_create_table_position extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->createTable( '{{%position}}', [
            'position_id'     => $this->primaryKey(),
            'name'            => $this->string(),
            'profession_id'   => $this->integer(),
            'department_id'   => $this->integer(),
            'additional_info' => $this->text()
        ], $this->tableOptions );
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable( '{{%position}}' );
    }
}
