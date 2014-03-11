<?php

namespace Seo\Grid;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use ZfcDatagrid\Column;

class SeoGridFactory implements FactoryInterface {

  /**
   * Create service
   *
   * @param ServiceLocatorInterface $sm
   * @return mixed
   */
  public function createService(ServiceLocatorInterface $sm)
  {
    $dataGrid = new \ZfcDatagrid\Service\DatagridFactory();
    $dataGrid = $dataGrid->createService($sm);
    $dataGrid->setTitle('Seo');
    $dataGrid->setDefaultItemsPerPage(20);
    $em = $sm->get('doctrine.entitymanager.orm_default');
    $qb = $em->createQueryBuilder();
    $qb->select('s');
    $qb->from('Seo\Entity\Seo', 's');

    $dataGrid->setDataSource($qb);

    $col = new Column\Select('id', 's');
    $col->setWidth(1);
    $col->setSortDefault(1, 'DESC');
    $col->setIdentity();
    $col->setHidden(false);
    $col->setLabel('Id');
    $dataGrid->addColumn($col);

    $col = new Column\Select('pageId', 's');
    $col->setLabel('PageId');
    $dataGrid->addColumn($col);

    $col = new Column\Select('type', 's');
    $col->setLabel('Type');
//    $col->setReplaceValues(array(
//        'BUILDER' => 'Builder',
//        'JOB' => 'Job',
//        'HOMEOWNER' => 'Homeowner'
//    ));
    $dataGrid->addColumn($col);

    $col = new Column\Select('title', 's');
    $col->setLabel('Title');
    $dataGrid->addColumn($col);

    $col = new Column\Select('description', 's');
    $col->setLabel('Description');
    $dataGrid->addColumn($col);

    $col = new Column\Select('keywords', 's');
    $col->setLabel('Keywords');
    $dataGrid->addColumn($col);

    $action2 = new Column\Action\Icon();
    $action2->setIconClass('icon-edit');
    $action2->setAttribute('href', "/seo/update/" . $action2->getRowIdPlaceholder());
    $action2->setAttribute('data-toggle', 'modal');
    $action2->setAttribute('data-target', '#updateModal');

    $action3 = new Column\Action\Icon();
    $action3->setIconClass('icon-remove');
    $action3->setAttribute('href', '/seo/remove/' . $action3->getRowIdPlaceholder());
    $action3->setAttribute('data-toggle', 'modal');
    $action3->setAttribute('data-target', '#removeModal');

    $col = new Column\Action();
    $col->setLabel('Actions');
    $col->setWidth(1);
    $col->addAction($action2);
    $col->addAction($action3);
    $dataGrid->addColumn($col);

    return $dataGrid;
  }

}
