<?php

namespace Seo\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Form;
use ZfcDatagrid\Datagrid;
use Seo\Service\SeoService;
use Zend\View\Model\ViewModel;

class SeoController extends AbstractActionController {

  /**
   * @var SeoService
   */
  protected $seoService;

  /**
   * @var Form
   */
  protected $seoForm;

  /**
   * @var Datagrid
   */
  protected $seoGrid;

  /**
   * @param SeoService $seoService
   */
  public function __construct(SeoService $seoService)
  {
    $this->seoService = $seoService;
  }

  public function addAction()
  {
    if ($this->request->isPost()) {
      $this->seoForm->setData($this->request->getPost());
      if ($this->seoForm->isValid()) {
        $this->seoService->add($this->seoForm->getData());
        $this->flashMessenger()->addSuccessMessage("Seo record has been successfully created");
        return $this->redirect()->toRoute('seo', array('action' => 'list'));
      }
    }
    return array('form' => $this->seoForm);
  }

  public function updateAction()
  {
    if (!$seo = $this->loadObject($this->seoService, "Seo record doesn't exist.")) {
      return $this->redirect()->toRoute('seo', array('action' => 'list'));
    }
    $this->seoForm->bind($seo);
    if ($this->request->isPost()) {
      $this->seoForm->setData($this->request->getPost());
      if ($this->seoForm->isValid()) {
        $this->seoService->update($this->seoForm->getData());
        $this->flashMessenger()->addSuccessMessage(sprintf('Seo "%s" has been successfully updated.', $seo->getId()));
        return $this->redirect()->toRoute('seo', array('action' => 'list'));
      }
    }

    $view = new ViewModel(array('id' => $seo->getId(), 'form' => $this->seoForm));
    $view->setTerminal(true);
    return $view;
  }

  public function removeAction()
  {
    if (!$seo = $this->loadObject($this->seoService, "Seo doesn't exist.")) {
      return $this->redirect()->toRoute('seo', array('action' => 'list'));
    }

    if ($this->request->isPost()) {
      $del = $this->request->getPost('del', 'No');
      if ($del == 'Yes') {
        $this->seoService->remove($seo);
        $this->flashMessenger()->addSuccessMessage('Seo record has been removed.');
      }
      return $this->redirect()->toRoute('seo', array('action' => 'list'));
    }

    $view = new ViewModel(array('seo' => $seo));
    $view->setTerminal(true);
    return $view;
  }

  public function listAction()
  {
    $grid = $this->seoGrid;
    $grid->execute();

    $view = new ViewModel();
    $view->addChild($grid->getResponse(), 'grid');
    $view->setVariable('addSeoForm', $this->seoForm);
    return $view;
  }

  /**
   * @param \Zend\Form\Form $seoForm
   */
  public function setSeoForm(Form $seoForm)
  {
    $this->seoForm = $seoForm;
  }

  /**
   * @param \ZfcDatagrid\Datagrid $seoGrid
   */
  public function setSeoGrid(Datagrid $seoGrid)
  {
    $this->seoGrid = $seoGrid;
  }

}
