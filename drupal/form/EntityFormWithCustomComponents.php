<?php

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Entity\EntityFormBuilderInterface;
use Drupal\Core\Entity\EntityRepositoryInterface;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TempStore\PrivateTempStoreFactory;
use Drupal\iucn_assessment\Plugin\AssessmentWorkflow;
use Symfony\Component\DependencyInjection\ContainerInterface;

class EntityFormWithCustomComponents extends ContentEntityForm {

  /** @var \Drupal\Core\Form\FormBuilderInterface */
  protected $entityFormBuilder;

  /** @var \Drupal\node\NodeInterface */
  protected $nodeRevision;

  /** @var string */
  protected $fieldName;

  /** @var \Drupal\Core\Entity\Display\EntityFormDisplayInterface */
  protected $entityFormDisplay;

  /** @var \Drupal\Core\Entity\Display\EntityFormDisplayInterface|null  */
  protected $nodeFormDisplay;

  public function __construct(EntityRepositoryInterface $entity_repository, EntityTypeBundleInfoInterface $entity_type_bundle_info = NULL, TimeInterface $time = NULL, EntityFormBuilderInterface $entity_form_builder = NULL, EntityTypeManagerInterface $entityTypeManager = NULL) {
    parent::__construct($entity_repository, $entity_type_bundle_info, $time);
    $this->setEntityTypeManager($entityTypeManager);
    $this->entityFormBuilder = $entity_form_builder;
    $this->entityFormDisplay = $this->entityTypeManager->getStorage('entity_form_display');

    $routeMatch = $this->getRouteMatch();
    $this->nodeRevision = $routeMatch->getParameter('node_revision');
    $this->fieldName = $routeMatch->getParameter('field');

    $this->nodeFormDisplay = $this->entityFormDisplay->load("{$this->nodeRevision->getEntityTypeId()}.{$this->nodeRevision->bundle()}.default");
    foreach ($this->nodeFormDisplay->getComponents() as $name => $component) {
      // Remove all other fields except one we get from $_GET parameter.
      if ($name != $this->fieldName) {
        $this->nodeFormDisplay->removeComponent($name);
      }
    }
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.repository'),
      $container->get('entity_type.bundle.info'),
      $container->get('datetime.time'),
      $container->get('entity.form_builder'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = $this->entityFormBuilder->getForm($this->nodeRevision, 'default', [
      'form_display' => $this->nodeFormDisplay,
      'entity_form_initialized' => TRUE,
    ]);
    return $form;
  }
}
