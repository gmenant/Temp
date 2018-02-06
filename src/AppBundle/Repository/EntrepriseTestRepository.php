<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class EntrepriseTestRepository extends \Doctrine\ORM\EntityRepository
{

     public function findByMotCle1($mot_cle)
    {
        $qb = $this->createQueryBuilder('e');
        $qb->where('e.nom like :mot')
            ->setParameters(array('mot' => '%'.$mot_cle.'%'));

        return $qb->getQuery()->getResult();
    }


    public function deleteEntry($mot_cle)
    {
        $qb = $this->createQueryBuilder('e');
        $qb ->delete('Entreprise e')
            ->where('e.nom like :mot')
            ->setParameters(array('mot' => '%'.$mot_cle.'%'));

        return $qb->getQuery()->getResult();
    }

}

