<?php
/*
 * This file is part of the Magallanes package.
 *
 * (c) Hector Nguyen <hectornguyen@octopius.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mage\Task\BuiltIn\Composer;

use Mage\Task\AbstractTask;

/**
 * Abstract Task for Composer
 *
 * @author Hector Nguyen <hectornguyen@octopius.com>
 */
abstract class ComposerAbstractTask extends AbstractTask
{
    protected function getComposerCmd()
    {
        $phpCmd = $this->getParameter('php_cmd', $this->getConfig()->general('php_cmd', 'php '));
        $composerCmd = $this->getParameter('composer_cmd', $this->getConfig()->general('composer_cmd', $phpCmd . 'composer.phar'));
        return $this->getConfig()->general('composer_cmd', $composerCmd);
    }
}
