<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;

/**
 * @property $id                   integer
 * @property $email                string
 * @property $password_hash        string
 * @property $auth_key             string
 * @property $created_at           integer
 */

class User extends ActiveRecord implements IdentityInterface
{
    const PLACEHOLDER_AVATAR = 'logo.png';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @param $password
     *
     * @return bool
     */
    public function validatePassword( $password )
    {
        return Yii::$app->security->validatePassword( $password, $this->password_hash );
    }

    /**
     * @param string $authKey
     *
     * @return bool
     */
    public function validateAuthKey( $authKey )
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @return integer|null
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @return string|null
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param mixed $token
     * @param null  $type
     *
     * @throws NotSupportedException
     * @return null
     */
    public static function findIdentityByAccessToken( $token, $type = null )
    {
        throw new NotSupportedException( '"findIdentityByAccessToken" is not implemented.' );
    }

    /**
     * @param int|string $id
     *
     * @return null|static
     */
    public static function findIdentity( $id )
    {
        return static::findOne( [ 'id' => $id ] );
    }

    /**
     * @param $email
     *
     * @return null|static
     */
    public static function findByEmail( $email )
    {
        return static::findOne( [ 'email' => $email ] );
    }

}