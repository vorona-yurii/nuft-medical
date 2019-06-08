<?php

namespace app\models\forms;

use app\models\Factor;
use app\models\Position;
use app\models\PositionFactor;
use app\models\Setting;


/**
 * Class SettingForm
 * @package app\models\forms
 */
class SettingForm extends Setting
{
    public $enable_email_file;
    public $template_email;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [ ['enable_email_file'], 'integer' ],
            [ ['template_email'], 'string' ]
        ];
    }

    public function saveSettings()
    {
        if ( $this->validate() ) {
            Setting::setSetting( 'enable_email_file', $this->enable_email_file );
            Setting::setSetting( 'template_email', $this->template_email );
        }
    }
}