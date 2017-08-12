<?php

namespace PruebaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PruebaBundle\Entity\Persona;
use PruebaBundle\Entity\Usuario;
use PruebaBundle\Entity\Telefono;
use PruebaBundle\Form\PersonaType;
use PruebaBundle\Form\TelefonoType;
use PruebaBundle\Entity\Curso;
use PruebaBundle\Form\CursoType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TelefonoController extends Controller
{
    private $session;

    public function __construct(){
        $this->session = new Session();
    }

    public function defaultAction()
    {
        // replace this example code with whatever you need
        $telefonos=new Telefono();
        $telefonos=$this->getDoctrine()
            ->getRepository('PruebaBundle:Telefono')
            ->findAll();
        return $this->render('PruebaBundle:telefono:default.html.twig',array(
            "telefono" => $telefonos
            ));
    }

    public function addAction(Request $request)
    {
        $telefono=new Telefono();
        $form= $this->createForm(TelefonoType::class,$telefono);
        $form->add('Agregar',SubmitType::class,array("attr"=>array("class"=>"form-submit btn btn-success")));

        $form -> handleRequest($request);
        if ($form -> isSubmitted()){
            if($form -> isValid()){
            	$telefono1=new Telefono();
                $em=$this->getDoctrine()->getEntityManager();
                $telefono_repo=$em->getRepository("PruebaBundle:Telefono");                
                $telefono1=$telefono_repo ->findOneBy(array("telefono"=>$form->get("telefono")->getData()));
                if($telefono1==Null){
                	$telefono1=new Telefono();
                    $telefono1->setTelefono($form->get("telefono")->getData());
                    $telefono1->setPersona($this->getUser()->getPersona());
                    $em=$this->getDoctrine()->getEntityManager();
                    $em->persist($telefono1);
                    $flush=$em->flush();
                    if($flush==null){
                        $status = "El Telefono se ha registrado satisfactoriamente";
                    }
                    else{
                        $status = "No se ha registrado Correctamente el telefono";
                    }
                }
                else{
                    $status = "El Telefono ya existe";
                }  
            }
            else{
                $status = "No se ha registrado Correctamente el Telefono";
            }
        $telefonos=new Telefono();
        $telefonos=$this->getDoctrine()
            ->getRepository('PruebaBundle:Telefono')
            ->findAll();
        return $this->redirectToRoute('telefono',array(
            "telefono" => $telefonos
            ));

        }
        return $this->render('PruebaBundle:telefono:add.html.twig',array(
            "form" => $form->createView()
        	));
    }

    public function editAction($id,Request $request)
    {   
        $telefono=new Telefono();
        $form= $this->createForm(TelefonoType::class,$telefono);
        $form->add('Editar',SubmitType::class,array("attr"=>array("class"=>"form-submit btn btn-success")));

        $form -> handleRequest($request);
        if ($form -> isSubmitted()){
            if($form -> isValid()){
                $em=$this->getDoctrine()->getEntityManager();
                $telefono_repo=$em->getRepository("PruebaBundle:Telefono");
                $telefono=$telefono_repo ->find($id);
                if(count($telefono)!=0){
                    $telefono->settelefono($form->get("telefono")->getData());
                    $em=$this->getDoctrine()->getEntityManager();
                    $em->persist($telefono);
                    $flush=$em->flush();
                    if($flush==null){
                        $status = "El telefono se ha modificado satisfactoriamente";
                    }
                    else{
                        $status = "No se ha modificado Correctamente el telefono";
                    }
                }
            }
            else{
                $status = "No se ha modificado Correctamente el telefono";
            }
            $this->session->getFlashBag()->add("status",$status);
            $telefonos=new Telefono();
            $telefonos=$this->getDoctrine()
                ->getRepository('PruebaBundle:Telefono')
                ->findAll();
            return $this->redirectToRoute('telefono',array(
                "telefono" => $telefonos
                ));
        }
        return $this->render('PruebaBundle:telefono:add.html.twig',array(
            "form" => $form->createView()
            ));
    }



    public function deleteAction($id)
    {
        $telefono=$this->getDoctrine()
            ->getRepository('PruebaBundle:Telefono')
            ->find($id);
        $em= $this -> getDoctrine()->getManager();
        $em->remove($telefono);
        $em->flush();
        $this->addFlash(
                'status',
                'telefono Removido'
        );
       return $this->redirectToRoute('telefono');
    }
    
}
