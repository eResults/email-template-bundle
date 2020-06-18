<?php

declare(strict_types=1);

namespace eResults\EmailTemplateBundle\PHPUnitExtensions;

use DG\BypassFinals;
use PHPUnit\Runner\BeforeTestHook;

final class BypassFinalsExtension implements BeforeTestHook
{
    public function executeBeforeTest(string $test): void
    {
        BypassFinals::enable();
    }
}
