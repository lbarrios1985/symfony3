<?php

namespace PruebaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PruebaBundle\Entity\Persona;
use PruebaBundle\Entity\Usuario;
use PruebaBundle\Entity\Curso;
use PruebaBundle\Entity\PersonaCurso;
use PruebaBundle\Form\PersonaType;
use PruebaBundle\Form\UsuarioType;
use PruebaBundle\Form\TelefonoType;
use PruebaBundle\Form\CursoType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class PersonaController extends Controller
{
    private $session;

    public function __construct(){
        $this->session = new Session();
    }

    public function addAction(Request $request)
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
            }
            else{
                $status = "No te has registrado Correctamente";
            }
        $this->session->getFlashBag()->add("status",$status);
        $persona=$this->getDoctrine()
            ->getRepository('PruebaBundle:Persona')
            ->findAll();
        return $this->render('PruebaBundle:Default:index.html.twig',array(
            "error" => $error,
            "last_username" => $lastUsername,
            "persona" => $persona,
            "form" => $form->createView()
            ));

        }
        $persona=$this->getDoctrine()
            ->getRepository('PruebaBundle:Persona')
            ->findAll();
        return $this->render('PruebaBundle:persona:add.html.twig',array(
            "error" => $error,
            "last_username" => $lastUsername,
            "persona" => $persona,
            "form" => $form->createView()
            ));
       
    }

    public function editAction($id,Request $request)
    {   
        $authentificationUtils = $this->get("security.authentication_utils");
        $error = $authentificationUtils->getLastAuthenticationError();
        $lastUsername = $authentificationUtils->getLastUsername();
        

        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class,$usuario);

        $form -> handleRequest($request);
        if ($form -> isSubmitted()){
            if($form -> isValid()){
                $persona=$this->getDoctrine()
                    ->getRepository('PruebaBundle:Persona')
                    ->find($id);
                $em=$this->getDoctrine()->getEntityManager();
                $usuario_repo=$em->getRepository("PruebaBundle:Usuario");
                $usuario=$usuario_repo ->findByPersona($persona);
                if(count($usuario)!=0){
                    $persona= $usuario[0]->getPersona();
                    $persona->setNombre($form->get("persona")->getData());

                    $usuario[0]->setNombre($form->get("nombre")->getData());
                    $usuario[0]->setCorreo($form->get("correo")->getData());

                    $factory=$this->get("security.encoder_factory");
                    $encoder= $factory->getEncoder($usuario[0]);
                    $clave= $encoder->encodePassword($form->get("clave")->getData(),$usuario[0]->getSalt());

                    $usuario[0]->setClave($clave);
                    $usuario[0]->setPersona($persona);

                    $em=$this->getDoctrine()->getEntityManager();
                    $em->persist($persona);
                    $flush=$em->flush();
                    if($flush==null){
                        $em->persist($usuario[0]);
                        $flush=$em->flush();
                        if($flush==null){
                            $status = "El usuario se ha editado satisfactoriamente";
                        }
                        else{
                            $status = "No se edito Correctamente";
                        }
                    }
                    else{
                        $status = "No se edito Correctamente";
                    }
                }  
            }
            else{
                $status = "No se edito Correctamente";
            }
            $this->addFlash(
                    'status',
                    'Persona editada'
            );
            $persona=$this->getDoctrine()
                ->getRepository('PruebaBundle:Persona')
                ->findAll();
            return $this->redirectToRoute('prueba_homepage',array(
                "error" => $error,
                "last_username" => $lastUsername,
                "persona" => $persona,
                "form" => $form->createView()
                ));

        }
        $persona=$this->getDoctrine()
            ->getRepository('PruebaBundle:Persona')
            ->findAll();
        return $this->render('PruebaBundle:persona:add.html.twig',array(
            "error" => $error,
            "last_username" => $lastUsername,
            "persona" => $persona,
            "form" => $form->createView()
            ));
       
    }



    public function deleteAction($id,$admin)
    {
        $authentificationUtils = $this->get("security.authentication_utils");
        $error = $authentificationUtils->getLastAuthenticationError();
        $lastUsername = $authentificationUtils->getLastUsername();

        $persona=$this->getDoctrine()
            ->getRepository('PruebaBundle:Persona')
            ->find($id);
        $personaCurso=$this ->getDoctrine()
            ->getRepository('PruebaBundle:PersonaCurso')
            ->findByPersona($persona);
        $telefono=$this ->getDoctrine()
            ->getRepository('PruebaBundle:Telefono')
            ->findByPersona($persona);
        $usuario=$this ->getDoctrine()
            ->getRepository('PruebaBundle:Usuario')
            ->findOneByPersona($persona);


        if ($persona!=null){
            if ($personaCurso!=null){
                $em= $this -> getDoctrine()->getManager();
                foreach ($personaCurso as $per) {
                    $em->remove($per);
                    $em->flush();
                }
            }
            if ($telefono!=null){
                $em= $this -> getDoctrine()->getManager();
                foreach ($telefono as $tel) {
                    $em->remove($tel);
                    $em->flush();
                };
            }
            $em= $this -> getDoctrine()->getManager();
            $em->remove($usuario);
            $em->flush();

            $em= $this -> getDoctrine()->getManager();
            $em->remove($persona);
            $em->flush();
                    
            $this->addFlash(
                    'status',
                    'Persona eliminada'
            );
        }
        $persona=$this->getDoctrine()
            ->getRepository('PruebaBundle:Persona')
            ->findAll();

        if ($admin==0){
            return $this->redirectToRoute('prueba_homepage',array(
                "persona" => $persona,
                "error" => $error,
                "last_username" => $lastUsername
            ));
        }
        else{
            $this->get('security.token_storage')->setToken(null);
            return $this->redirectToRoute('logout');
        }
    }
}
