<?php
namespace Mage\Task\BuiltIn\Composer;

use Mage\Task\BuiltIn\Composer\ComposerAbstractTask;
use Mage\Task\ErrorWithMessageException;

class UpdateTask extends ComposerAbstractTask
{
    /**
     * Returns the Title of the Task
     * @return string
     */
    public function getName()
    {
        return 'Update vendors via Composer [built-in]';
    }

    /**
     * Runs the task
     *
     * @return boolean
     * @throws ErrorWithMessageException
     */
    public function run()
    {
        $dev = $this->getParameter('dev', true);
        return $this->runCommand($this->getComposerCmd() . ' update' . ($dev ? ' --dev' : ' --no-dev'));
    }
}
