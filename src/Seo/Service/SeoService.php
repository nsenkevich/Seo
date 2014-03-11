<?php

namespace Seo\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use Seo\Repository\SeoRepository;
use \Seo\Entity\Seo as SeoEntity;

class SeoService implements ServiceManagerAwareInterface {

  /**
   * @var ServiceManager
   */
  protected $serviceManager;

  /**
   * @var SeoRepository
   */
  protected $seoRepository;

  /**
   * @param SeoRepository $seoRepository
   */
  public function __construct(SeoRepository $seoRepository)
  {
    $this->seoRepository = $seoRepository;
  }

  /**
   * @param int $id
   * @return SeoEntity
   */
  public function getSeoById($id)
  {
    return $this->seoRepository->find($id);
  }

  /**
   * @param SeoEntity $entity
   * @throws ServiceException
   */
  public function add(SeoEntity $entity)
  {
    try {
      $this->seoRepository->saveEntity($entity);
    } catch (\Exception $exc) {
      throw new ServiceException($exc->getMessage());
    }
  }

  /**
   * @param SeoEntity $entity
   * @throws ServiceException
   */
  public function update(SeoEntity $entity)
  {
    try {
      $this->seoRepository->saveEntity($entity);
    } catch (\Exception $exc) {
      throw new ServiceException($exc->getMessage());
    }
  }

  /**
   * @param SeoEntity $entity
   * @throws ServiceException
   */
  public function remove(SeoEntity $entity)
  {
    try {
      $this->seoRepository->removeEntity($entity);
    } catch (\Exception $exc) {
      throw new ServiceException($exc->getMessage());
    }
  }

  /**
   * @param int $id
   * @param string $type
   * @return SeoEntity
   */
  public function getSeoByTypeId($id, $type)
  {
    return $this->seoRepository->findOneBy(array('pageId' => $id, 'type' => $type));
  }

  /**
   * @param int $id
   * @return SeoEntity
   */
  public function getObject($id)
  {
    return $this->seoRepository->find($id);
  }

  /**
   * @return ServiceManager
   */
  public function getServiceManager()
  {
    return $this->serviceManager;
  }

  /**
   * @param ServiceManager $serviceManager
   */
  public function setServiceManager(ServiceManager $serviceManager)
  {
    $this->serviceManager = $serviceManager;
  }

}
