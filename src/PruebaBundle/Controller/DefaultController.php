<?php

namespace PruebaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PruebaBundle\Entity\Persona;
use PruebaBundle\Entity\Usuario;
use PruebaBundle\Entity\Curso;
use PruebaBundle\Entity\PersonaCurso;
use PruebaBundle\Form\PersonaType;
use PruebaBundle\Form\TelefonoType;
use PruebaBundle\Form\CursoType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	$persona=new Persona();
        $persona=$this->getDoctrine()
            ->getRepository('PruebaBundle:Persona')
            ->findAll();
 		return $this->render('PruebaBundle:Default:index.html.twig',array('persona'=>$persona));
    }
}
