<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Soporte
 *
 * @ORM\Table(name="soporte")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SoporteRepository")
 */
class Soporte
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
     * @ORM\Column(name="asunto", type="string", length=255)
     */
    private $asunto;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="prioridad", type="string", length=45, nullable=true)
     */
    private $prioridad;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=50, nullable=true)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcionSolucion", type="string", length=255, nullable=true)
     */
    private $descripcionSolucion;

    /**
     * @var int
     *
     * @ORM\Column(name="idUsuario", type="integer")
     */
    private $idUsuario;
    
    /**
     * @var int
     *
     * @ORM\Column(name="idTipoSoporte", type="integer")
     */
    private $idTipoSoporte;


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
     * Set asunto
     *
     * @param string $asunto
     *
     * @return Soporte
     */
    public function setAsunto($asunto)
    {
        $this->asunto = $asunto;

        return $this;
    }

    /**
     * Get asunto
     *
     * @return string
     */
    public function getAsunto()
    {
        return $this->asunto;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Soporte
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set prioridad
     *
     * @param string $prioridad
     *
     * @return Soporte
     */
    public function setPrioridad($prioridad)
    {
        $this->prioridad = $prioridad;

        return $this;
    }

    /**
     * Get prioridad
     *
     * @return string
     */
    public function getPrioridad()
    {
        return $this->prioridad;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return Soporte
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set descripcionSolucion
     *
     * @param string $descripcionSolucion
     *
     * @return Soporte
     */
    public function setDescripcionSolucion($descripcionSolucion)
    {
        $this->descripcionSolucion = $descripcionSolucion;

        return $this;
    }

    /**
     * Get descripcionSolucion
     *
     * @return string
     */
    public function getDescripcionSolucion()
    {
        return $this->descripcionSolucion;
    }

    /**
     * Set idUsuario
     *
     * @param integer $idUsuario
     *
     * @return Soporte
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
    
    
    /**
     * Set idTipoSoporte
     *
     * @param integer $idTipoSoporte
     *
     * @return Soporte
     */
    public function setIdTipoSoporte($idTipoSoporte)
    {
        $this->idTipoSoporte = $idTipoSoporte;

        return $this;
    }

    /**
     * Get idTipoSoporte
     *
     * @return int
     */
    
    public function getIdTipoSoporte()
    {
        return $this->idTipoSoporte;
    }
    
    
    //.. Relación con la entidad Usuario.
    
    /**
    * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="soporte")
    * @ORM\JoinColumn(name="idUsuario", referencedColumnName="id")
    */
    
    private $usuario;
    
    //.. Relación con la entidad TipoSoporte.
    
    /**
    * @ORM\ManyToOne(targetEntity="TipoSoporte", inversedBy="soporte")
    * @ORM\JoinColumn(name="idTipoSoporte", referencedColumnName="id")
    */
    
    private $tipoSoporte;
    
    
    /**
     * Set usuario
     *
     * @param integer $usuario
     *
     * @return Soporte
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
    
    
    /**
     * Set tipoSoporte
     *
     * @param integer $tipoSoporte
     *
     * @return Soporte
     */
    public function setTipoSoporte($tipoSoporte)
    {
        $this->tipoSoporte = $tipoSoporte;
        return $this;
    }
    
    /**
     * Get tipoSoporte
     *
     * @return int
     */
    public function getTipoSoporte()
    {
        return $this->tipoSoporte;
    }
     
}

