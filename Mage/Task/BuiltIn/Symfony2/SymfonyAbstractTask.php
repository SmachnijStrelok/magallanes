<?php
/*
 * This file is part of the Magallanes package.
 *
 * (c) Hector Nguyen <hectornguyen@octopius.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mage\Task\BuiltIn\Symfony2;

use Mage\Task\AbstractTask;

/**
 * Abstract Task for Symfony2
 *
 * @author Hector Nguyen <hectornguyen@octopius.com>
 */
abstract class SymfonyAbstractTask extends AbstractTask
{
    protected function getAppPath()
    {
        if ($this->getConfig()->general('symfony_version', '2') == '3') {
            $defaultAppPath = 'bin/console';
        } else {
            $defaultAppPath = 'app/console';
        }

        return $this->getConfig()->general('symfony_app_path', $defaultAppPath);
    }
}
