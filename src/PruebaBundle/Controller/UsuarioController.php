<?php

namespace PruebaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PruebaBundle\Entity\Persona;
use PruebaBundle\Entity\Usuario;
use PruebaBundle\Form\UsuarioType;
use Symfony\Component\HttpFoundation\Session\Session;

class UsuarioController extends Controller
{
    private $session;

    public function __construct(){
        $this->session = new Session();
    }

    public function loginAction(Request $request)
    {
    	$authentificationUtils = $this->get("security.authentication_utils");
    	$error = $authentificationUtils->getLastAuthenticationError();
    	$lastUsername = $authentificationUtils->getLastUsername();
        

        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class,$usuario);

        $form -> handleRequest($request);
        if ($form -> isSubmitted()){
            if($form -> isValid()){
                $em=$this->getDoctrine()->getEntityManager();
                $usuario_repo=$em->getRepository("PruebaBundle:Usuario");
                $usuario=$usuario_repo ->findOneBy(array("nombre"=>$form->get("nombre")->getData()));
                if(count($usuario)==0){
                    $usuario= new Usuario();
                    $persona= new Persona();
                    $persona->setNombre($form->get("persona")->getData());

                    $usuario->setNombre($form->get("nombre")->getData());
                    $usuario->setCorreo($form->get("correo")->getData());

                    $factory=$this->get("security.encoder_factory");
                    $encoder= $factory->getEncoder($usuario);
                    $clave= $encoder->encodePassword($form->get("clave")->getData(),$usuario->getSalt());

                    $usuario->setClave($clave);
                    $usuario->setPersona($persona);

                    $em=$this->getDoctrine()->getEntityManager();
                    $em->persist($persona);
                    $flush=$em->flush();
                    if($flush==null){
                        $em->persist($usuario);
                        $flush=$em->flush();
                        if($flush==null){
                            $status = "El usuario se ha registrado satisfactoriamente";
                        }
                        else{
                            $status = "No te has registrado Correctamente";
                        }
                    }
                    else{
                        $status = "No te has registrado Correctamente";
                    }
                }
                else{
                    $status = "El Usuario ya existe";
                }  
            }
            else{
                $status = "No te has registrado Correctamente";
            }
        $persona=$this->getDoctrine()
            ->getRepository('PruebaBundle:Persona')
            ->findAll();
        $this->session->getFlashBag()->add("status",$status);
        return $this->render('PruebaBundle:usuario:login.html.twig',array(
            "error" => $error,
            "last_username" => $lastUsername,
            "persona" => $persona,
            "form" => $form->createView()
            ));

        }
        $persona=$this->getDoctrine()
            ->getRepository('PruebaBundle:Persona')
            ->findAll();
        return $this->render('PruebaBundle:usuario:login.html.twig',array(
        	"error" => $error,
        	"last_username" => $lastUsername,
            "persona" => $persona,
            "form" => $form->createView()
        	));
    }
}
