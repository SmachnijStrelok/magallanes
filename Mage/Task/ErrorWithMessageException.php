<?php
/*
 * This file is part of the Magallanes package.
 *
 * (c) J.Moriarty <moriarty@codefelony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mage\Task;

use Exception;

/**
 * Exception that indicates that the Task has an Error and also a Message indicating the Error
 *
 * @author J.Moriarty <moriarty@codefelony.com>
 */
class ErrorWithMessageException extends Exception
{
}
