<?php

/*
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0+
 */

namespace HeimrichHannot\ContaoNewsAlertBundle\Components;

use Contao\ModuleModel;
use HeimrichHannot\ContaoNewsAlertBundle\EventListener\NewsPostedListener;
use HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertSubscribeModule;

class Cronjob
{
    public function minutely()
    {
        $this->sendNewsalerts('minutely');
    }

    public function hourly()
    {
        $this->sendNewsalerts('hourly');
    }

    public function daily()
    {
        $this->sendNewsalerts('daily');
    }

    public function weekly()
    {
        $this->sendNewsalerts('weekly');
    }

    public function monthly()
    {
        $this->sendNewsalerts('monthly');
    }

    private function sendNewsalerts($strInterval)
    {
        $objModules = ModuleModel::findBy(
            ['type=?', 'newsalertCronIntervall=?'],
            [NewsalertSubscribeModule::MODULE_NAME, $strInterval]
        );
        if (!$objModules) {
            return;
        }

        $listener = new NewsPostedListener();

        while ($objModules->next()) {
            $listener->callByModule($objModules->current());
        }
    }
}
