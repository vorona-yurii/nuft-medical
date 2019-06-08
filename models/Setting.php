<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property $setting_id   integer
 * @property $key          string
 * @property $value        text
 */

class Setting extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%setting}}';
    }

    /**
     * @param $key
     * @return null
     */
    public static function getSetting( $key )
    {
        if ( $setting = self::findOne( [ 'key' => $key ] ) ) {
            return $setting->value;
        }

        return null;

    }

    /**
     * @param $key
     * @param $value
     * @return Setting|null|static
     */
    public static function setSetting( $key, $value )
    {
        if ( !$setting = self::findOne( [ 'key' => $key ] ) ) {
            $setting = new self();
            $setting->key = $key;
        }
        $setting->value = $value;
        $setting->save();

        return $setting;
    }
}