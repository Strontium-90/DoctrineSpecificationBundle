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

Create your specification builder:
```php

use Strontium\SpecificationBundle\Builder\SpecificationBuilderInterface;

class OwnedByCurrentUser implements SpecificationBuilderInterface
{
    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @param TokenStorageInterface $tokenStorage
     * @return $this
     */
    public function setContextManager(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function buildSpecification(SpecificationFactory $spec, array $options)
    {
        return $spec->eq([
            'field'     => $options['field'],
            'value'     => $this->tokenStorage->getToken()->getUser(),
            'dql_alias' => $options['dql_alias']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefined(['field'])
            ->setDefaults([
                'field' => 'user',
            ]);
    }
}

```

Register you builder by adding tag `specification`:
```yml
    my_app.specification.owned_by_current_user:
        class: MyApp\MyBundle\Specification\OwnedByCurrentUser
        arguments:
            - @security.token_storage
        tags:
            - { name: specification, alias: ownedByCurrentUser }

``

Use it somewhere in your app

```php
   class CommentController extends Controller
   {
   
       public function indexAction(Request $request)
       {
           $spec = $this->get('specification.factory')->ownedByCurrentUser();
           
           $comments = $this->getRepository()->match($spec);
           
           return [
               'comments' => $comments
           ];
       }
```

Or create other specification builders depends from it:

```php
class NewCommentsOwnedByCurrentUser extends AbstractSpecificationBuilder
{
    public function buildSpecification(SpecificationFactory $spec, array $options)
    {
        return $spec->andX(
            $spec->ownedByCurrentUser(),
            $spec->gte('createdAt', new \DateTime('-5 days'))
        );
    }
}

```

You can use Specification filter form in you controllers.
Firsts create FornType:
```php
class AppointmentChainFilterType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', 'text', [
                'specification' => function (SpecificationFactory $spec, $value) {
                    return $spec->like([
                        'field' => 'text',
                        'value' => $value
                    ]);
                },
            ])
            ->add('status', 'choice', [
                'choices'               => ['draft', 'posted', 'deleted'],
                'specification'         => 'in'
                'specification_options' => [
                    'field' => 'status'
                ],
            ])
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                $form = $event->getForm();
                $text = $form->get('text')->getNormData();
                if ($text && strlen($text) < 3) {
                    $form['text']->addError(
                        new FormError("Search text should contains at least 3 symbols.")
                    );
                }
            })
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'specification' => 'andX',
        ]);
    }

    public function getName()
    {
        return 'posts_filter';
    }

    public function getParent()
    {
        return 'resource_filter';
    }
} 
```


```php
    public function indexAction(Request $request)
    {
        $specFactory = $this->get('specification.factory');
        $specification = $specFactory->ownedByCurrentUser();
                      
        $filterForm = $this->createForm('posts_filter');
        $filterForm->handleRequest($request);
            
        if ($filterForm->isValid() && $filterSpecification = $filterForm->getData()) {
            $specification = $specFactory->andX($filterSpecification, $specification); 
        }
        $comments = $this->getRepository()->match($specification);  
        // ....
```        
