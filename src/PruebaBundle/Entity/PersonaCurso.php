<?php

namespace PruebaBundle\Entity;

/**
 * PersonaCurso
 */
class PersonaCurso
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \PruebaBundle\Entity\Persona
     */
    private $persona;

    /**
     * @var \PruebaBundle\Entity\Curso
     */
    private $curso;


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
     * Set persona
     *
     * @param \PruebaBundle\Entity\Persona $persona
     *
     * @return PersonaCurso
     */
    public function setPersona( $persona )
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
     * Set curso
     *
     * @param \PruebaBundle\Entity\Curso $curso
     *
     * @return PersonaCurso
     */
    public function setCurso( $curso)
    {
        $this->curso = $curso;

        return $this;
    }

    /**
     * Get curso
     *
     * @return \PruebaBundle\Entity\Curso
     */
    public function getCurso()
    {
        return $this->curso;
    }

    /**
     * Get curso
     *
     * @return \PruebaBundle\Entity\Curso
     */
    public function __toString()
    {
        return (string) $this->getPersona();
    }

}
