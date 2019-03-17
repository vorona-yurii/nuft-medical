<?php

use app\db\Migration;

/**
 * Class m181024_102003_create_table_user
 */
class m181024_102003_create_table_user extends Migration
{
    /**
     * @return bool|void
     * @throws \yii\db\Exception
     */
    public function up()
    {
        $this->createTable( '{{%user}}', [
            'id'                   => $this->primaryKey()->comment('ID пользователя'),
            'name'                 => $this->string()->comment('Имя пользователя'),
            'email'                => $this->string()->unique()->comment('Email пользователя'),
            'auth_key'             => $this->string( 32 )->comment('Ключ авторизации'),
            'password_hash'        => $this->string()->notNull()->comment('Пароль'),
            'password_reset_token' => $this->string()->unique()->comment('Токен пароля(системный)'),
            'created_at'           => $this->integer()->comment('Дата создания')
        ], $this->tableOptions );

        Yii::$app->db
            ->createCommand()
            ->batchInsert( '{{%user}}',
                [
                    'name',
                    'email',
                    'password_hash',
                    'created_at'
                ],
                [
                    [
                        'Main Admin',
                        'admin@admin.net',
                        '$2y$13$4SyZmXuPbZK5vlHyv8ff6ez74q40ZK1a.kuWgc8dYP/h0SFTfKgQ.', //xickGX
                        time()
                    ],
                ]
            )
            ->execute();
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable( '{{%user}}' );
    }
}
