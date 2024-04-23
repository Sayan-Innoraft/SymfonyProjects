<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use App\Validator\Constraints\CheckDescLength;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Movie class is used for setting movie details and storing the data in a
 * database using ORM.
 */
#[ORM\Table('movie')]
#[Entity(repositoryClass: MovieRepository::class)]
#[UniqueEntity([
  'fields' => 'title',
  'message' => 'Movie title is already taken.',
])]
class Movie {

  #[ORM\Id]
  #[ORM\GeneratedValue(strategy: 'AUTO')]
  #[ORM\Column(type: 'integer')]
  private int $id;

  #[Assert\NoSuspiciousCharacters]
  #[Assert\NotNull]
  #[ORM\Column(type: 'string',length: 100)]
  #[Assert\Length([
    'max' => 100,
    'min' => 1
  ])]
  private string $title;

  #[Assert\NotNull]
  #[ORM\Column(type: 'integer')]
  #[Assert\Range([
    'min' => 1600,
    'max' => 2024,
    'notInRangeMessage' => 'Year must be between {{ min }} and {{ max }}'
  ])]
  private int $year;

  #[Assert\NotNull]
  #[Assert\Length([
    'min' => 2,
    'max' => 500,
    'maxMessage' => 'Maximum {{ limit }} characters are allowed',
    'minMessage' => 'Minimum {{ limit }} characters are allowed'
  ])]
  #[ORM\Column(type: 'text')]
  private string $description;

  #[Assert\NotNull]
  #[ORM\Column(type: 'string')]
  private string $thumbnail;

  public function getId():int {
    return $this->id;
  }

  public function setId(int $id):Movie {
    $this->id = $id;
    return $this;
  }

  public function getTitle():string {
    return $this->title;
  }

  public function setTitle(string $title):Movie{
    $this->title = $title;
    return $this;
  }

  public function getYear():int {
    return $this->year;
  }

  public function setYear(int $year):Movie {
    $this->year = $year;
    return $this;
  }

  public function getDescription():string {
    return $this->description;
  }

  public function setDescription(string $description):Movie {
    $this->description = $description;
    return $this;
  }

  public function getThumbnail():string {
    return $this->thumbnail;
  }

  public function setThumbnail(string $thumbnail):Movie {
    $this->thumbnail = $thumbnail;
    return $this;
  }

}
