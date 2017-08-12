<?php

namespace PruebaBundle\Entity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Usuario
 */

class Usuario implements UserInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $correo;

    /**
     * @var string
     */
    private $clave;

    /**
     * @var \PruebaBundle\Entity\Persona
     */
    private $persona;

    //AUTH

    public function getUserName(){

        return $this->nombre;
    }

    public function getSalt(){
        return null;
    }

    public function getRoles(){
        return array("Admin");
    }


    public function eraseCredentials(){
        
    }

    public function getPassword(){
        return $this->clave;
    }


    //END AUTH




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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Usuario
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
     * Set correo
     *
     * @param string $correo
     *
     * @return Usuario
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo
     *
     * @return string
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set clave
     *
     * @param string $clave
     *
     * @return Usuario
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave
     *
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set persona
     *
     * @param \PruebaBundle\Entity\Persona $persona
     *
     * @return Usuario
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
}
