<?php

namespace Drupal\guests\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\file\Entity\File;

/**
 * Class for Our Form.
 */
class GuestsForm extends FormBase {

  /**
   * This func is for Getting ID of Our Adding Guest Form.
   */
  public function getFormId() {
    return 'guest_form';
  }

  /**
   * This Func is for Build our Adding Guest Form.
   *
   * @param array $form
   *   Hooray.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Hooray.
   *
   * @return array
   *   Hello.
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {

    $form['#prefix'] = '<div id="form-wrapper" class="col-md-6 col-xs-12 ml-auto mr-auto">';
    $form['#suffix'] = '</div>';
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#description' => $this->t('MinLength - 2 symb, MaxLength - 100 symb'),
      '#placeholder' => $this->t("Enter Your Name"),
      '#required' => TRUE,
      '#wrapper_attributes' => ['class' => 'col-xs-12'],
      '#maxlength' => 100,
      '#ajax' => [
        'callback' => '::validateFormAjaxName',
        'event' => 'change',
        'progress' => [
          'type' => 'none',
        ],
      ],
      '#attributes' => [
        'data-disable-refocus' => 'true',
        'autocomplete' => 'off',
      ],
      '#suffix' => '<p class="false_form false_name"></p>',
    ];
    $form['email'] = [
      '#required' => TRUE,
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#description' => $this->t('Only Alpha, ., _, - and @ Allowed'),
      '#placeholder' => $this->t("Enter Your Email"),
      '#maxlength' => 100,
      '#ajax' => [
        'callback' => '::validateFormAjaxEmail',
        'event' => 'change',
        'progress' => [
          'type' => 'none',
        ],
      ],
      '#attributes' => [
        'data-disable-refocus' => 'true',
        'autocomplete' => 'off',
      ],
      '#suffix' => '<p class="false_form false_email"></p>',
    ];
    $form['phone'] = [
      '#required' => TRUE,
      '#type' => 'textfield',
      '#title' => $this->t('Phone'),
      '#description' => $this->t('Only Numbers and +- are Allowed. MinLength - 7, MaxLength - 13'),
      '#placeholder' => $this->t("Enter Your Phone Number"),
      '#maxlength' => 13,
      '#ajax' => [
        'callback' => '::validateFormAjaxPhone',
        'event' => 'change',
        'progress' => [
          'type' => 'none',
        ],
      ],
      '#attributes' => [
        'data-disable-refocus' => 'true',
        'autocomplete' => 'off',
      ],
      '#suffix' => '<p class="false_form false_phone"></p>',
    ];
    $form['review'] = [
      '#title' => $this->t('Review'),
      '#type' => 'textarea',
      '#placeholder' => $this->t("Enter Your Review"),
      '#required' => TRUE,
      '#ajax' => [
        'callback' => '::validateFormAjaxReview',
        'event' => 'change',
        'progress' => [
          'type' => 'none',
        ],
      ],
      '#resizable' => 'none',
      '#attributes' => [
        'data-disable-refocus' => 'true',
        'autocomplete' => 'off',
        'class' => [
          'guests-form-review',
        ],
      ],
      '#suffix' => '<p class="false_form false_review"></p>',
    ];
    $form['avatar'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Avatar'),
      '#description' =>
      $this->t('Avatar.   Avaiable Formats - jpeg, jpg, png; MaxSize - 2MB'),
      '#placeholder' => $this->t("Your Cat Photo"),
      '#upload_validators' => [
        'file_validate_extensions' => ['jpeg jpg png'],
        'file_validate_size' => [2097152],
      ],
      '#upload_location' => 'public://guests_photos/avatars',
    ];
    $form['photo'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Photo in Review'),
      '#description' =>
      $this->t('Review Photo.   Avaiable Formats - jpeg, jpg, png; MaxSize - 5MB'),
      '#placeholder' => $this->t("Your Cat Photo"),
      '#upload_validators' => [
        'file_validate_extensions' => ['jpeg jpg png'],
        'file_validate_size' => [5242880],
      ],
      '#upload_location' => 'public://guests_photos/reviews',
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#button_type' => 'primary',
      '#value' => $this->t('Add Review'),
      '#attributes' => [
        'class' => ['btn', 'btn-warning'],
      ],
      '#ajax' => [
        'callback' => '::setMessage',
        'wrapper' => 'form-wrapper',
        'effect' => 'fade',
        'event' => 'click',
      ],
    ];
    return $form;
  }

  /**
   * This func is for Validation of Our Guests.
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    $name = $form_state->getValue('name');
    $email = $form_state->getValue('email');
    $phone = $form_state->getValue('phone');
    $review = $form_state->getValue('review');
    $requiers_name = "/[-_'A-Za-z0-9 ]/";
    $requiers_phone = '/[-_+0-9]/';
    $requiers_email = '/[-_@A-Za-z.]/';
    $length_name = strlen($name);
    $length_email = strlen($email);
    $length_phone = strlen($phone);
    $length_review = strlen($review);

    if ($length_name < 2) {
      $form_state->setErrorByName(
        'name',
        $this->t(
          "Name: Oh No! Your Name is Shorter Than 2 Symbols(. Don't be Shy, it's Alright."
        )
      );
    }
    elseif ($length_name > 100) {
      $form_state->setErrorByName(
        'name',
        $this->t(
          'Name: Oh No! Your Name is Longer Than 100 Symbols(. Can You Cut it a Bit?'
        )
      );
    }
    for ($i = 0; $i < $length_name; $i++) {
      if (!preg_match($requiers_name, $name[$i])) {
        $form_state->setErrorByName('name',
          $this->t(
            "Name: Oh No! In Your Name %title You False Symbols(. Acceptable is: A-Z, 0-9 _ and '.", ['%title' => $name]
          )
        );
      }
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      for ($i = 0; $i < $length_email; $i++) {
        if (!preg_match($requiers_email, $email[$i])) {
          $form_state->setErrorByName('email',
            $this->t(
              'Mail: Oh No! Your Email %title is Invalid(', ['%title' => $email]
            )
          );
        }
      }
    }
    if ($length_email > 255) {
      $form_state->setErrorByName('email', $this->t(
        'Mail: On No, Your Email is too Long. MaxLength - 255. Please, Cut it Off. Your Length: %length.',
        ['%length' => $length_email]));
    }
    if (($length_phone > 13 || $length_phone < 7) && (!$length_phone == 0)) {
      $form_state->setErrorByName('phone', $this->t('Phone: Oh No! Your Phone Number %phone is Invalid(. The Length: %length.',
        ['%phone' => $phone, '%length' => strlen($phone)]));
    }
    for ($i = 0; $i < $length_phone; $i++) {
      if (!preg_match($requiers_phone, $phone[$i])) {
        $form_state->setErrorByName('phone', $this->t('Phone: Oh No! Your Phone Number %phone is Invalid(', ['%phone' => $phone]));
      }
    }
    if (empty($review)) {
      $form_state->setErrorByName('review', $this->t("Review: Oh No! Your Review Can't Be Empty(. Tell Us More about this situation."));
    }
    if ($length_review > 1023) {
      $form_state->setErrorByName('review', $this->t(
        'Message: On No, Your Review is too Long. MaxLength - 1023. Please, Cut it Off. Your Length: %length.',
        ['%length' => $length_review]));
    }

  }

  /**
   * This func is for AJAX Redirect if Everything Fine or Setting Errors.
   *
   * @param array $form
   *   Comment smth.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Comment smth.
   */
  public function setMessage(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    if (!$form_state->hasAnyErrors()) {
      $url = Url::fromRoute('guests.main-page');
      $command = new RedirectCommand($url->toString());
      $response->addCommand($command);
      return $response;
    }
    return $form;
  }

  /**
   * This Func Validate Our Name Number with AJAX.
   *
   * @param array $form
   *   Comment smth.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Comment smth.
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   *   Comment smth.
   */
  public function validateFormAjaxName(array &$form, FormStateInterface $form_state): AjaxResponse {

    $name = $form_state->getValue('name');
    $emptyname = empty($name);
    $response = new AjaxResponse();
    $lenName = strlen($name);
    $length_name = strlen($name);
    $requiers_name = "/[-_'A-Za-z0-9 ]/";
    if (($length_name > 100 || $length_name < 2) && $length_name != 0) {
      $message = $this->t('Name: Oh No! Your Name %name  Have False Length. The Length: %length.',
        ['%name' => $name, '%length' => $length_name]);
      $response->addCommand(
        new HtmlCommand(
          '.false_name',
          $message
        )
      );
      return $response;
    }
    for ($i = 0; $i < $length_name; $i++) {
      if (!preg_match($requiers_name, $name[$i])) {
        $message = $this->t("Name: Oh No! Your Name %name is Invalid(. You Should Use A-z, 0-9, and special symbols (-_').", ['%name' => $name]);
        $response->addCommand(
          new HtmlCommand(
            '.false_name',
            $message
          )
        );
        return $response;
      }
      else {
        $message = '';
        $response->addCommand(
          new HtmlCommand(
            '.false_name',
            $message
          )
        );
        return $response;
      }
    }
    if (($length_name == 0) || ($emptyname) || ($length_name <= 100 && $length_name >= 2)) {
      $message = '';
      $response->addCommand(
        new HtmlCommand(
          '.false_name',
          $message
        )
      );
      return $response;
    }
    return $response;
  }

  /**
   * This Func Validate Our Email with AJAX.
   *
   * @param array $form
   *   Comment smth.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Comment smth.
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   *   Comment smth.
   */
  public function validateFormAjaxEmail(array &$form, FormStateInterface $form_state): AjaxResponse {
    $email = $form_state->getValue('email');
    $length_email = strlen($email);
    $emptyemail = empty($email);
    $response = new AjaxResponse();
    $requiers = '/[-_@A-Za-z.]/';
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $tmp = 0;
      for ($i = 0; $i < (strlen($email)); $i++) {
        if (!preg_match($requiers, $email[$i])) {
          $message = $this->t('Mail: Oh No! Your Email %title is Invalid(', ['%title' => $email]);
          $tmp++;
          $response->addCommand(
            new HtmlCommand(
              '.false_email',
              $message
            )
          );
          break;
        }
      }
      if ($tmp == 0) {
        $message = '';
        $response->addCommand(
          new HtmlCommand(
            '.false_email',
            $message
          )
        );
      }
    }
    else {
      $message =
        $this->t('Mail: Oh No! Your Email %title is Invalid(', ['%title' => $email]);
      $response->addCommand(
        new HtmlCommand(
          '.false_email',
          $message
        )
      );
    }
    if ($length_email > 255) {
      $message = $this->t(
        'Mail: On No, Your Email is too Long. MaxLength - 255. Please, Cut it Off. Your Length: %length.',
        ['%length' => $length_email]);
      $response->addCommand(
        new HtmlCommand(
          '.false_review',
          $message
        )
      );
      return $response;
    }
    if (($emptyemail)) {
      $message = '';
      $response->addCommand(
        new HtmlCommand(
          '.false_email',
          $message
        )
      );
      return $response;
    }
    return $response;
  }

  /**
   * This Func Validate Our Phone Number with AJAX.
   *
   * @param array $form
   *   Comment smth.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Comment smth.
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   *   Comment smth.
   */
  public function validateFormAjaxPhone(array &$form, FormStateInterface $form_state): AjaxResponse {
    $phone = $form_state->getValue('phone');
    $emptyphone = empty($phone);
    $response = new AjaxResponse();
    $requiers = '/[-+0-9]/';
    $length_phone = strlen($phone);
    if ($length_phone != 0) {
      if ($phone[0] != '+') {
        $message = $this->t("Phone: Pal, You Should Start to Enter a Phone Number with '+'. %phone is Invalid(", ['%phone' => $phone]);
        $response->addCommand(
          new HtmlCommand(
            '.false_phone',
            $message
          )
        );
        return $response;
      }
      if (($length_phone > 13 || $length_phone < 7) && ($length_phone != 0)) {
        $message = $this->t('Phone: Oh No! Your Phone Number %phone is Invalid(. The Length: %length, and it Should Be in Range (7-13).',
          ['%phone' => $phone, '%length' => strlen($phone)]);
        $response->addCommand(
          new HtmlCommand(
            '.false_phone',
            $message
          )
        );
        return $response;
      }
      for ($i = 0; $i < $length_phone; $i++) {
        if (!preg_match($requiers, $phone[$i])) {
          $message = $this->t('Phone: Oh No! Your Phone Number %phone is Invalid(', ['%phone' => $phone]);
          $response->addCommand(
            new HtmlCommand(
              '.false_phone',
              $message
            )
          );
          return $response;
        }
        else {
          $message = '';
          $response->addCommand(
            new HtmlCommand(
              '.false_phone',
              $message
            )
          );
          return $response;
        }
      }
    }
    if ((strlen($phone) == 0) || ($emptyphone)) {
      $message = '';
      $response->addCommand(
        new HtmlCommand(
          '.false_phone',
          $message
        )
      );
      return $response;
    }
    return $response;
  }

  /**
   * This Func Validate Our Name Number with AJAX.
   *
   * @param array $form
   *   Comment smth.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Comment smth.
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   *   Comment smth.
   */
  public function validateFormAjaxReview(array &$form, FormStateInterface $form_state): AjaxResponse {

    $review = $form_state->getValue('review');
    $emptyreview = empty($review);
    $response = new AjaxResponse();
    $length_review = strlen($review);
    if (($length_review == 0) || ($emptyreview)) {
      $message = $this->t('Message: On No, Your Review is Empty. Tell Us More!');
      $response->addCommand(
        new HtmlCommand(
          '.false_review',
          $message
        )
      );
      return $response;
    }
    if ($length_review > 1023) {
      $message = $this->t(
        'Message: On No, Your Review is too Long. MaxLength - 1023. Please, Cut it Off. Your Length: %length.',
        ['%length' => $length_review]);
      $response->addCommand(
        new HtmlCommand(
          '.false_review',
          $message
        )
      );
      return $response;
    }
    if ($length_review < 1023 && ($length_review != 0)) {
      $message = '';
      $response->addCommand(
        new HtmlCommand(
          '.false_review',
          $message
        )
      );
      return $response;
    }
    return $response;
  }

  /**
   * This Func is for Submitting Our Form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $name = $form_state->getValue('name');
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
      'timestamp' => time(),
    ];
    \Drupal::database()->insert('guests')->fields($data)->execute();
    $this->messenger()
      ->addStatus($this->t('You(%name) Added Review.', ['%name' => $name]));

  }

}
