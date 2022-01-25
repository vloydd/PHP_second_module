<?php

namespace Drupal\guests\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Defines a Confirmation Form to confirm Deleting of Something by ID.
 */
class GuestsDelete extends ConfirmFormBase {

  /**
   * ID of the item to delete.
   *
   * @var int
   */
  public $id;

  /**
   * Func for Getting ID  of Deleting Form.
   *
   * @return string
   *   Rebuild ID of Our Form.
   */
  public function getFormId(): string {
    return 'guests_delete';
  }

  /**
   * Func for Building Deleting Form.
   *
   * {@inheritdoc}
   *
   * @return array
   *   Rebuild Basic Form.
   */
  public function buildForm(array $form, FormStateInterface $form_state, $id = NULL): array {
    $this->id = $id;
    return parent::buildForm($form, $form_state);
  }

  /**
   * Func for Setting Question of Deleting Form.
   *
   * @return string
   *   Set Question.
   */
  public function getQuestion():string {
    return $this->t('Do You Want to Delete  this Review?');
  }

  /**
   * Func for Setting Description of Deleting Form.
   *
   * @return string
   *   Set Description for Form.
   */
  public function getDescription():string {
    return $this->t('Do you Really Want to Delete Review with ID %id ?', ['%id' => $this->id]);
  }

  /**
   * Func for Setting Text on Button that Confirms Deleting.
   *
   * @return string
   *   Set Text of Confirm Button Form.
   */
  public function getConfirmText():string {
    return $this->t('Delete');
  }

  /**
   * Func for Setting Text on Button that Cancels Deleting.
   *
   * @return string
   *   Set Text on Button that Cancels Confirming.
   */
  public function getCancelText():string {
    return $this->t('Cancel');
  }

  /**
   * Func for Setting Redirect After Canceling.
   *
   * @return \Drupal\Core\Url
   *   To Set Redirect After We Cancelled.
   */
  public function getCancelUrl(): Url {
    return new Url('guests.main-page');
  }

  /**
   * Func for Submitting Deletion.
   *
   * {@inheritDoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state, $id = NULL): void {
    \Drupal::database()->delete('guests')->condition('id', $this->id)->execute();
    $this->messenger()
      ->addStatus($this->t('You Deleted Your Review №%id?', ['%id' => $this->id]));
    $form_state->setRedirect('guests.main-page');
  }

}
