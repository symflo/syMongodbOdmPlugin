<?php

/**
 * syMongodbOdmEnsureIndexTask
 * @author Florent Mondoloni
 */
class syMongodbOdmEnsureIndexTask extends sfBaseTask
{
    protected function configure()
    {
        $this->addOptions(array(
          new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
          new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
          new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
        ));

        $this->namespace        = 'sy';
        $this->name             = 'syMongodbOdmEnsureIndex';
        $this->briefDescription = 'apply mongodb ensure indexes';
        $this->detailedDescription = <<<EOF
The [syMongodbOdmEnsureIndexTask|INFO] The old ensure indexes are deleted and new ones are created.
Call it with:

[php symfony syMongodbOdmEnsureIndexTask|INFO]
EOF;
    }

    /**
     * execute
     * @param  array  $arguments
     * @param  array  $options
     */
    protected function execute($arguments = array(), $options = array())
    {
        $context = sfContext::createInstance($this->configuration);
        $indexer = $context->get('dependency_injection_container')->get('symflo.mongodbodm.ensureindexer');

        try {
            $indexer->applyIndex();
            $this->logSection('Success ensure indexes', null);
        } catch (Exception $e) {
            $this->logSection('Fail apply ensure indexes', $e->getMessage());
        }
    }
}
