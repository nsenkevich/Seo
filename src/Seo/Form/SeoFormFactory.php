<?php

namespace Seo\Form;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\Form\Annotation\AnnotationBuilder;
use Seo\Entity\Seo;

class SeoFormFactory implements FactoryInterface {

  /**
   * Create service
   *
   * @param ServiceLocatorInterface $sm
   * @return \Zend\Form\Form
   */
  public function createService(ServiceLocatorInterface $sm)
  {
    $seo = new Seo(Null, Null, Null, Null);
    $builder = new AnnotationBuilder();
    $form = $builder->createForm($seo);
    $form->bind($seo);
    $form->get('type')->setValueOptions(Seo::$entityType);
//    $form->add(array(
//        'type' => 'DoctrineModule\Form\Element\ObjectSelect',
//        'name' => 'pageId',
//        'priority' => 5,
//        'options' => array(
//            'label' => 'Homeowners',
//            'object_manager' => $sm->get('doctrine.entitymanager.orm_default'),
//            'target_class' => '\BuilderJob\Entity\Homeowner',
//            'property' => 'email',
//            'empty_option' => '--- please choose ---',
//            'is_method' => true,
//            'find_method' => array(
//                'name' => 'findAll',
//            ),
//        ),
//    ));
    $form->add(array(
        'type' => 'DoctrineModule\Form\Element\ObjectSelect',
        'name' => 'pageId',
        'priority' => 5,
        'options' => array(
            'label' => 'Builder',
            'object_manager' => $sm->get('doctrine.entitymanager.orm_default'),
            'target_class' => '\BuilderJob\Entity\Builder',
            'property' => 'email',
            'empty_option' => '--- please choose ---',
            'is_method' => true,
            'find_method' => array(
                'name' => 'findAll',
            ),
        ),
    ));
    $form->getInputFilter()->add(array(
        'name' => 'pageId',
        'required' => TRUE,
    ));
//
//    $form->add(array(
//        'type' => 'DoctrineModule\Form\Element\ObjectSelect',
//        'name' => 'pageId',
//        'priority' => 5,
//        'options' => array(
//            'label' => 'Job',
//            'object_manager' => $sm->get('doctrine.entitymanager.orm_default'),
//            'target_class' => '\BuilderJob\Entity\Job',
//            'property' => 'title',
//            'empty_option' => '--- please choose ---',
//            'is_method' => true,
//            'find_method' => array(
//                'name' => 'findAll',
//            ),
//        ),
//    ));
    $form->add(array('name' => 'security', 'type' => 'Zend\Form\Element\Csrf'));
    $form->add(array('name' => 'submit',
        'attributes' => array('type' => 'submit', 'value' => 'Add Seo')
    ));
    return $form;
  }

}
