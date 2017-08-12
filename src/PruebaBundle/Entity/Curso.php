<?php

namespace PruebaBundle\Entity;

/**
 * Curso
 */
class Curso
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
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
     * Set curso
     *
     * @param string $curso
     *
     * @return Curso
     */
    public function setCurso($curso)
    {
        $this->curso = $curso;

        return $this;
    }

    /**
     * Get curso
     *
     * @return string
     */
    public function getCurso()
    {
        return $this->curso;
    }

     /**
     * Get curso
     *
     * @return string
     */
    public function __toString()
    {
        return $this->curso;
    }
}
