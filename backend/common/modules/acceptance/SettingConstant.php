<?php

namespace common\modules\acceptance;

class SettingConstant
{
    public const PLUGIN_SECTION = 'PS_ACCEPTANCE_08032022';

    public const GENERATE_ATTEMPT_MAX
        = SettingConstant::PLUGIN_SECTION . '_GENERATE_ATTEMPT_MAX';

    public const DELAY
        = SettingConstant::PLUGIN_SECTION . '_DELAY';

    public const CODE_ATTEMPT_MAX
        = SettingConstant::PLUGIN_SECTION . '_CODE_ATTEMPT_MAX';

    public const CONTACT_SECTION = 'CONTACT_SECTION';

    public const CONTACT_PHONE
        = SettingConstant::CONTACT_SECTION . '_CONTACT_PHONE';

    public const CONTACT_ADDRES
        = SettingConstant::CONTACT_SECTION . '_CONTACT_ADDRES';

    public const CONTACT_PHONE_CALLBACK
        = SettingConstant::CONTACT_SECTION . '_CONTACT_PHONE_CALLBACK';
}
