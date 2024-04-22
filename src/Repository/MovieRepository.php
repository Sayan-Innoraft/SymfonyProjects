<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MovieRepository extends  ServiceEntityRepository {
  private ManagerRegistry $registry;

  /**
   * @param \Doctrine\Persistence\ManagerRegistry $registry
   */
  public function __construct(ManagerRegistry $registry){
    parent::__construct($registry, Movie::class);
  }

  public function save(Movie $movie):void {
    $this->getEntityManager()->persist($movie);
    $this->getEntityManager()->flush();
  }

  public function delete(Movie $movie):void {
    $this->getEntityManager()->remove($movie);
    $this->getEntityManager()->flush();
  }

}
