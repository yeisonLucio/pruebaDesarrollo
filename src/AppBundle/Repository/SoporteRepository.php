<?php

namespace AppBundle\Repository;
use AppBundle\Entity\soportes;
/**
 * SoporteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SoporteRepository extends \Doctrine\ORM\EntityRepository
{
    public function soportesCliente($idUsuaro)
    {
        $consulta = $this->getEntityManager()->createQuery(
            'SELECT u.nombre,count(s.idUsuario) total
            FROM AppBundle\Entity\soporte s
            WHERE s.idUsuario = :idUsuario
            group by u.nombre'
        )->setParameter('nombre', $idUsuaro);
            $valor = $consulta->getResult();
        return $valor;

    }
    
}
