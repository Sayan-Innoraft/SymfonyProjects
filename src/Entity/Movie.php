<?php

namespace App\Entity;

use App\Constraints\CheckDescLength;
use App\Repository\MovieRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * Movie class is used for setting movie details and storing the data in
 * a database using ORM.
 */

#[Entity(repositoryClass: MovieRepository::class)]
#[UniqueEntity([
  'fields' => 'title',
  'message' => 'Movie title is already taken.',
])]
class Movie {

  #[Id]
  #[GeneratedValue(strategy: 'AUTO')]
  #[Column(type: 'integer')]
  private int $id;

  #[NotNull]
  #[Column(type: 'string',length: 100)]
  #[Assert\Length([
    'max' => 100,
    'min' => 1
  ])]
  private string $title;

  #[Column(type: 'integer')]
  private int $year;

  #[CheckDescLength]
  #[Column(type: 'string')]
  private string $description;

  #[Column(type: 'string')]
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
