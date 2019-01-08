<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoSoporte
 *
 * @ORM\Table(name="tipo_soporte")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TipoSoporteRepository")
 */
class TipoSoporte
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var text
     *
     * @ORM\Column(name="descripcion", type="text", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @var int
     *
     * @ORM\Column(name="idUsuario", type="integer")
     */
    private $idUsuario;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return TipoSoporte
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param text $descripcion
     *
     * @return TipoSoporte
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return text
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set idUsuario
     *
     * @param integer $idUsuario
     *
     * @return TipoSoporte
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get idUsuario
     *
     * @return int
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }
    
    //..Relaciones..
    
    //.. Relación con la entidad Usuario.
    
    /**
    * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="tipoSoporte")
    * @ORM\JoinColumn(name="idUsuario", referencedColumnName="id")
    */
    
    private $usuario;
         
    //..Relación con la entidad Soporte
    
    /**
    * @ORM\OneToMany(targetEntity="Soporte", mappedBy="tipoSoporte")
    */
    private $soporte;
    
    public function __constructSoporte()
    {
      $this->soporte = new ArrayCollection();
    }
    
    
        /**
     * Set usuario
     *
     * @param integer $usuario
     *
     * @return TipoSoporte
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return int
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
    
}

