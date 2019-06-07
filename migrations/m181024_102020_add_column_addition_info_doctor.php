<?php

use app\db\Migration;

/**
 * Class m181024_102020_add_column_addition_info_doctor
 */
class m181024_102020_add_column_addition_info_doctor extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->addColumn('{{%doctor}}', 'additional_info', $this->text());
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropColumn( '{{%doctor}}', 'additional_info' );
    }
}
