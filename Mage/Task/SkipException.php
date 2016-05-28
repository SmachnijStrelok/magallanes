<?php
/*
 * This file is part of the Magallanes package.
 *
 * (c) Hector Nguyen <hectornguyen@octopius.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mage\Task;

use Exception;

/**
 * Exception that indicates that the Task was Skipped
 *
 * @author Hector Nguyen <hectornguyen@octopius.com>
 */
class SkipException extends Exception
{
}
