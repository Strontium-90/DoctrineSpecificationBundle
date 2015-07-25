<?php

namespace Strontium\DoctrineSpecificationBundle\DependencyInjection;

use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;

class DoctrineSpecificationExtension extends AbstractResourceExtension
{
    protected $applicationName = 'v3d';

    protected $configFiles     = array(
        'forms.yml',
    );

    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $this->configure($config, new Configuration(), $container);
    }
}
