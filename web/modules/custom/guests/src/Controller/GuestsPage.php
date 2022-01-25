<?php

namespace Drupal\guests\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\file\Entity\File;

/**
 * Controller Class for Our Guests List and Form.
 */
class GuestsPage extends ControllerBase {

  /**
   * This func shows our content.
   *
   * @return array
   *   returns our Add Guests Form and Theme and Render Table for Results.
   */
  public function content(): array {
    $form = \Drupal::formBuilder()->getForm('Drupal\guests\Form\GuestsForm');
    $guests = $this->getGuests();
    return [
      '#theme' => 'guests-theme',
      '#form' => $form,
      '#guests' => $guests,
    ];
  }

  /**
   * This Function Gets Our Guests And Presents Them on Page.
   *
   * @return array
   *   Hooray.
   */
  public function getGuests(): array {
    $this->id = \Drupal::routeMatch()->getParameter('id');
    $query = \Drupal::database()->select('guests', 'g');
    $query->fields('g',
      [
        'id',
        'name',
        'email',
        'phone',
        'review',
        'avatar',
        'photo',
        'timestamp',
      ]);
    $query->orderBy('g.timestamp', 'DESC');
    $results = $query->execute()->fetchAll();
    $guests = [];
    $guests_list = [];
    foreach ($results as $data) {
      if ($data->avatar != NULL) {
        $avatar_file = File::load($data->avatar);
        $avatar_uri = $avatar_file->getFileUri();
        $avatar_url = \Drupal::service('file_url_generator')->generateAbsoluteString($avatar_uri);
      }
      else {
        $avatar_uri = '/sites/default/files/guests_photos/avatars/default_5.png';
        $avatar_url = 'http://two.docksal/sites/default/files/guests_photos/avatars/default_5.png';
      }
      if ($data->photo != NULL) {
        $photo_file = File::load($data->photo);
        $photo_uri = $photo_file->getFileUri();
        $photo_url = \Drupal::service('file_url_generator')->generateAbsoluteString($photo_uri);
        $photo = [
          'data' => [
            '#theme'      => 'image',
            '#alt'        => 'Photo_img',
            '#uri'        => $photo_uri,
            '#width'      => 400,
            '#attributes' => [
              'class' => [
                'guest_photo_img',
              ],
            ],
          ],
        ];
      }
      else {
        $photo_uri = NULL;
        $photo_url = NULL;
        $photo = NULL;
      }
      $delete_url = Url::fromRoute('guests.delete-form', ['id' => $data->id], []);
      $delete = [
        '#type' => 'link',
        '#title' => $this->t('Delete'),
        '#url' => $delete_url,
        '#options' => [
          'attributes' => [
            'class' => [
              'guests-item',
              'guests-edit-delete',
              'guests-delete',
              'use-ajax',
            ],
            'data-dialog-type' => 'modal',
          ],
        ],
      ];
      $edit_url = Url::fromRoute('guests.edit-form', ['id' => $data->id], []);
      $edit = [
        '#type' => 'link',
        '#title' => $this->t('Edit'),
        '#url' => $edit_url,
        '#options' => [
          'attributes' => [
            'class' => [
              'guests-item',
              'guests-edit-delete',
              'guests-edit',
              'use-ajax',
            ],
            'data-dialog-type' => 'modal',
          ],
        ],
      ];
      $avatar = [
        'data' => [
          '#theme'      => 'image',
          '#alt'        => 'catImg',
          '#uri'        => $avatar_uri,
          '#width'      => 200,
          '#attributes' => [
            'class' => [
              'guest_avatar_img',
            ],
          ],
        ],
      ];
      $guests[$data->id] = [
        'id' => $data->id,
        'name' => $data->name,
        'email' => $data->email,
        'phone' => $data->phone,
        'review' => $data->review,
        'avatar' => $avatar,
        'photo' => $photo,
        'avatar_uri' => $avatar_uri,
        'avatar_url' => $avatar_url,
        'photo_uri' => $photo_uri,
        'photo_url' => $photo_url,
        'time' => date('d.m.y H:i:s', $data->timestamp),
        'delete' => $delete,
        'edit' => $edit,
      ];
    }
    return $guests;
  }

}
