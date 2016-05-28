<?php
/*
 * This file is part of the Magallanes package.
 *
 * (c) Hector Nguyen <hectornguyen@octopius.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mage\Command\BuiltIn;

use Mage\Command\AbstractCommand;
use Mage\Console;

/**
 * Command for displaying the Version of Magallanes
 *
 * @author Hector Nguyen <hectornguyen@octopius.com>
 */
class VersionCommand extends AbstractCommand
{
    /**
     * Display the Magallanes Version
     * @see \Mage\Command\AbstractCommand::run()
     */
    public function run()
    {
        Console::output('Running <blue>Magallanes</blue> version <bold>' . MAGALLANES_VERSION . '</bold>', 0, 2);

        return 0;
    }
}
