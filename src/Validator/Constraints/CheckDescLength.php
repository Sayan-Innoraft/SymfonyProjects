<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Checks length of the movie description.
 */
#[\Attribute]
class CheckDescLength extends Compound {

  /**
   * @param array $options
   *
   * @return \Symfony\Component\Validator\Constraints\Length[]
   */
  protected function getConstraints(array $options):array {
    return [
      new Length([
        'min' => 2,
        'max' => 500,
        'maxMessage' => 'Maximum {{ limit }} characters are allowed',
        'minMessage' => 'Minimum {{ limit }} characters are allowed'
      ])
    ];
  }

}
