<?php

namespace Adiq\LiberoBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ActionRepository extends EntityRepository
{
    public function findNotRentedBooks()
    {
        $em = $this->getEntityManager();
        $actions = $em->createQuery(
                'SELECT p FROM AdiqLiberoBundle:Action p ORDER BY p.name ASC'
            )
            ->getResult();

    }
}