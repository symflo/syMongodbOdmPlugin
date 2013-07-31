<?php

/**
 * syMongodbOdmPluginConfiguration configuration.
 *
 * @package     syMongodbOdmPluginConfiguration
 * @subpackage  config
 * @author      Florent Mondoloni
 */
class syMongodbOdmPluginConfiguration extends sfPluginConfiguration
{
    /**
     * @see sfPluginConfiguration
     *
     * Initialize the service container
     */
    public function initialize()
    {
        $this->dispatcher->connect('context.load_factories', array($this, 'initializeServiceContainer'));
    }

    /**
     * Initialize mongo DB ODM.
     */
    public function initializeServiceContainer(sfEvent $event)
    {
        $context = $event->getSubject();
        $container = $context->get('dependency_injection_container');
        $types = sfConfig::get('app_syMongodbOdmPlugin_types');

        foreach ($types as $serviceName => $service) {
            $types[$serviceName] = $container->get($service);
        }

        $databasesConfig = sfConfig::get('app_syMongodbOdmPlugin_databases');
        if (!array_key_exists('default', $databasesConfig)) {
            throw new \Exception('Database default is not defined.');
        }

        $documents = sfConfig::get('app_syMongodbOdmPlugin_documents');
        if (null === $documents) {
            throw new \Exception('Documents is not defined in your config.');   
        }

        $config = array(
            'user'      => $databasesConfig['default']['user'],
            'password'  => $databasesConfig['default']['password'],
            'database'  => $databasesConfig['default']['database'],
            'host'      => $databasesConfig['default']['host'],
            'documents' => $documents,
            'types'     => $types
        );

        $dm = $container->get('symflo.mongodbodm.document.manager');
        $dm->getConnection()->getConfigurator()->setDefaultTypes($types);
        $dm->getConnection()->getConfigurator()->setConfig($config);
        $dm->getConnection()->init();
    }
}