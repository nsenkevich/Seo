<?php

namespace Seo\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * @ORM\Entity(repositoryClass="Seo\Repository\SeoRepository")
 * @ORM\Table(name = "seo")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 * @Annotation\Name("seoForm")
 */
class Seo {

  const PAGE = 'PAGE';
  const JOB = 'JOB';
  const BUILDER = 'BUILDER';
  const HOMEOWNER = 'HOMEOWNER';
  
  static public $entityType = array(
      self::PAGE => 'Page',
      self::JOB => 'Job',
      self::BUILDER => 'Builder',
      self::HOMEOWNER => 'Homeowner',
  );

  /**
   * @ORM\Id
   * @ORM\Column(type="integer");
   * @ORM\GeneratedValue(strategy="AUTO")
   * @Annotation\Exclude()
   */
  protected $id;

  /**
   * @ORM\Column(type = "string", length = 255, nullable = true);
   * @Annotation\Type("Zend\Form\Element\Select")
   * @Annotation\Required({"required":"true"})
   * @Annotation\Options({"label":"Type*",})
   */
  protected $type;

  /**
   * @ORM\Column(type="integer");
   * @Annotation\Exclude()
   */
  protected $pageId;

  /**
   * @var string
   * @ORM\Column(type="string", length=250, nullable=true)
   * @Annotation\Attributes({"type":"textarea" })
   * @Annotation\Options({"label":"Title*"})
   * @Annotation\Required({"required":"true" })
   * @Annotation\Filter({"name":"StripTags"})
   * @Annotation\Filter({"name":"StringTrim"})
   * @Annotation\Validator({"name":"StringLength", "options":{"min":"20","max":"250"}})
   */
  protected $title;

  /**
   * @var string
   * @ORM\Column(type="string", length=250, nullable=true)
   * @Annotation\Attributes({"type":"textarea"})
   * @Annotation\Options({"label":"Description*"})
   * @Annotation\Required({"required":"true" })
   * @Annotation\Filter({"name":"StripTags"})
   * @Annotation\Validator({"name":"StringLength", "options":{"min":"20","max":"250"}})
   */
  protected $description;

  /**
   * @var string
   * @ORM\Column(type="string", length=250, nullable=true)
   * @Annotation\Attributes({"type":"textarea" })
   * @Annotation\Options({"label":"Keywords*"})
   * @Annotation\Required({"required":"true" })
   * @Annotation\Filter({"name":"StripTags"})
   * @Annotation\Filter({"name":"StringTrim"})
   * @Annotation\Validator({"name":"StringLength", "options":{"min":"20","max":"250"}})
   */
  protected $keywords;

  /**
   * @param int $pageId
   * @param string $title
   * @param string $description
   * @param string $type
   * @param string $keywords
   */
  public function __construct($pageId, $title, $description, $type, $keywords = NULL)
  {
    $this->setTitle($title);
    $this->setDescription($description);
    $this->setKeywords($keywords);
    $this->setPageId($pageId);
    $this->setType($type);
  }

  public function getTitle()
  {
    return $this->title;
  }

  public function getDescription()
  {
    return $this->description;
  }

  public function getKeywords()
  {
    return $this->keywords;
  }

  public function getPageId()
  {
    return $this->pageId;
  }

  public function setTitle($title)
  {
    $this->title = $title;
  }

  public function setDescription($description)
  {
    $this->description = $description;
  }

  public function setKeywords($keywords)
  {
    $this->keywords = $keywords;
  }

  public function setPageId($pageId)
  {
    $this->pageId = $pageId;
  }

  public function getType()
  {
    return $this->type;
  }

  public function setType($type)
  {
    $this->type = $type;
  }

  public function getId()
  {
    return $this->id;
  }

  public function setId($id)
  {
    $this->id = $id;
  }

}
