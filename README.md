StrontiumSpecificationBundle
===================

[![Build Status](https://travis-ci.org/Strontium-90/SpecificationBundle.svg?branch=master)](https://travis-ci.org/Strontium-90/SpecificationBundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/f7c99c8d-062d-4082-81dc-e9ba9281908e/mini.png)](https://insight.sensiolabs.com/projects/f7c99c8d-062d-4082-81dc-e9ba9281908e)

Integraion of [Happyr/Doctrine-Specification](https://github.com/Happyr/Doctrine-Specification) into [Symfony 2](https://github.com/symfony/symfony) framework.

Installation
------------
Add composer dependency `composer require strontium/doctrine-specification-bundle`.
Register bundle in your Kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new \Strontium\SpecificationBundle\SpecificationBundle(),
    );
    // ...
}

```

Usage
--------------
Register
