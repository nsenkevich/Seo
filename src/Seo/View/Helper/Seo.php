<?php

namespace File\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Seo\Service\SeoService;

class Seo extends AbstractHelper {

  /**
   * @var SeoService
   */
  protected $seoService;

  /**
   * @param SeoService $seoService
   */
  public function __construct(SeoService $seoService)
  {
    $this->seoService = $seoService;
  }

  public function __invoke($id, $type)
  {
    $seo = $this->seoService->getSeoByTypeId($id, $type);
    if ($seo) {
      $view = $this->getView();
      $view->headTitle()->append(ucfirst($seo->getTitle()));
      $view->headMeta()->appendName('description', $this->cutText($seo->getDescription(), 155));
      $view->headMeta()->setName('keywords', $seo->getKeywords());
      return $view;
    }
  }

}
