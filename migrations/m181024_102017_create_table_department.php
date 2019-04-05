<?php

use app\db\Migration;

/**
 * Class m181024_102017_create_table_department
 */
class m181024_102017_create_table_department extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->createTable( '{{%department}}', [
            'department_id'     => $this->primaryKey(),
            'name'              => $this->string(),
            'head_employee_id'  => $this->integer(),
            'additional_info'   => $this->text()
        ], $this->tableOptions );
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable( '{{%department}}' );
    }
}
