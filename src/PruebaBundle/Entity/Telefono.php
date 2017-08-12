<?php

namespace PruebaBundle\Entity;

/**
 * Telefono
 */
class Telefono
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $telefono;

    /**
     * @var \PruebaBundle\Entity\Persona
     */
    private $persona;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Telefono
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set persona
     *
     * @param \PruebaBundle\Entity\Persona $persona
     *
     * @return Telefono
     */
    public function setPersona( $persona = null)
    {
        $this->persona = $persona;

        return $this;
    }

    /**
     * Get persona
     *
     * @return \PruebaBundle\Entity\Persona
     */
    public function getPersona()
    {
        return $this->persona;
    }
    /**
     * Get curso
     *
     * @return string
     */
    public function __toString()
    {
        return $this->telefono;
    }

}
