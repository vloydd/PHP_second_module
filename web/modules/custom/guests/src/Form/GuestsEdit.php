<?php

namespace Drupal\guests\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Database\Database;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element\Ajax;
use Drupal\Core\Url;
use Drupal\file\Entity\File;

/**
 * Our Form Edit Class.
 */
class GuestsEdit extends GuestsForm {
  /**
   * ID of the item to edit.
   *
   * @var int
   */
  public $id;

  /**
   * {@inheritdoc}
   */
  public function getFormId() :string {
    return 'guests_edit';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $id = NULL): array {
    $this->id = \Drupal::routeMatch()->getParameter('id');
    $conn = Database::getConnection();
    $data = [];
    if (isset($this->id)) {
      $query = $conn->select('guests', 'g')
        ->condition('id', $this->id)
        ->fields('g');
      $data = $query->execute()->fetchAssoc();
    }

    $form = parent::buildForm($form, $form_state);
    $form['#prefix'] = '<div id="form-edit-wrapper" class="col-xs-12 ml-auto mr-auto">';
    $form['name']['#default_value'] = (isset($data['name'])) ? $data['name'] : '';
    $form['email']['#default_value'] = (isset($data['email'])) ? $data['email'] : '';
    $form['review']['#default_value'] = (isset($data['review'])) ? $data['review'] : '';
    $form['phone']['#default_value'] = (isset($data['phone'])) ? $data['phone'] : '';
    $form['photo']['#default_value'][] = (isset($data['photo'])) ? $data['photo'] : '';
    $form['avatar']['#default_value'][] = (isset($data['avatar'])) ? $data['avatar'] : '';
    $form['actions']['submit']['#value'] = $this->t('Edit');
    $form['actions']['submit']['#ajax']['wrapper'] = 'form-edit-wrapper';
    $form['actions']['cancel'] = [
      '#type' => 'button',
      '#button_type' => 'primary',
      '#value' => $this->t('Cancel'),
      '#attributes' => [
        'class' => ['btn', 'btn-danger'],
      ],
      '#ajax' => [
        'callback' => '::setCancel',
        'effect' => 'fade',
        'event' => 'click',
      ],
    ];
    return $form;
  }

  /**
   *
   */
  public function setCancel(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    $url = Url::fromRoute('guests.main-page');
    $command = new RedirectCommand($url->toString());
    $response->addCommand($command);
    return $response;
  }

  /**
   * This func submitting form.
   *
   * @param array $form
   *   Comment smth.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Comment smth.
   *
   * @throws \Exception
   */
  public function submitForm(array &$form, FormStateInterface $form_state):void {
    $avatar = $form_state->getValue('avatar');
    $photo = $form_state->getValue('photo');
    if ($avatar !== NULL) {
      $fileOne = File::load($avatar[0]);
      if ($fileOne !== NULL) {
        $fileOne->setPermanent();
        $fileOne->save();
      }
    }
    if ($photo !== NULL) {
      $fileTwo = File::load($photo[0]);
      if ($fileTwo !== NULL) {
        $fileTwo->setPermanent();
        $fileTwo->save();
      }
    }
    $data = [
      'name' => $form_state->getValue('name'),
      'email' => $form_state->getValue('email'),
      'phone' => $form_state->getValue('phone'),
      'review' => $form_state->getValue('review'),
      'avatar' => $avatar[0],
      'photo' => $photo[0],
    ];

    if (isset($this->id)) {
      // Update data in database.
      \Drupal::database()->update('guests')->fields($data)->condition('id', ($this->id))->execute();
    }
    else {
      // Insert data to database.
      \Drupal::database()->insert('guests')->fields($data)->execute();
    }
    // Show message and redirect to list page.
    \Drupal::messenger()->addStatus($this->t('You Edited Your Review by: %name.', ['%name' => $form_state->getValue('name')]));
  }

}
