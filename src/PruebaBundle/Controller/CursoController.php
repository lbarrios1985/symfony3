<?php

namespace PruebaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PruebaBundle\Entity\Persona;
use PruebaBundle\Entity\PersonaCurso;
use PruebaBundle\Entity\Usuario;
use PruebaBundle\Form\PersonaType;
use PruebaBundle\Entity\Curso;
use PruebaBundle\Form\CursoType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CursoController extends Controller
{
    private $session;

    public function __construct(){
        $this->session = new Session();
    }

    public function defaultAction()
    {
        $personaCurso=$this->getDoctrine()
            ->getRepository('PruebaBundle:PersonaCurso')
            ->findAll();
        $cursos=$this->getDoctrine()
            ->getRepository('PruebaBundle:Curso')
            ->findAll();

        return $this->render('PruebaBundle:curso:default.html.twig',array(
            "curso" => $cursos,
            "personaCurso" => $personaCurso
            ));
    }

    public function addAction(Request $request)
    {
        $curso=new Curso();
        $form= $this->createForm(CursoType::class,$curso);
        $form->add('Agregar',SubmitType::class,array("attr"=>array("class"=>"form-submit btn btn-success")));

        $form -> handleRequest($request);
        if ($form -> isSubmitted()){
            if($form -> isValid()){
                $em=$this->getDoctrine()->getEntityManager();
                $curso_repo=$em->getRepository("PruebaBundle:Curso");
                $curso=$curso_repo ->findOneBy(array("curso"=>$form->get("curso")->getData()));
                if(count($curso)==0){
                    $curso=new Curso();
                    $curso->setCurso($form->get("curso")->getData());
                    
                    $em=$this->getDoctrine()->getEntityManager();
                    $em->persist($curso);
                    $flush=$em->flush();
                    if($flush==null){
                        $status = "El Curso se ha registrado satisfactoriamente";
                    }
                    else{
                        $status = "No se ha registrado Correctamente el curso";
                    }
                }
                else{
                    $status = "El Curso ya existe";
                }  
            }
            else{
                $status = "No se ha registrado Correctamente el curso";
            }
            $this->session->getFlashBag()->add("status",$status);
            $personaCurso=$this->getDoctrine()
            ->getRepository('PruebaBundle:PersonaCurso')
            ->findAll();
            $cursos=$this->getDoctrine()
            ->getRepository('PruebaBundle:Curso')
            ->findAll();

            return $this->redirectToRoute('curso',array(
                "curso" => $cursos,
                "personaCurso" => $personaCurso
            ));
        }
    }

    public function editAction($id,Request $request)
    {   
        $curso=new Curso();
        $form= $this->createForm(CursoType::class,$curso);
        $form->add('Editar',SubmitType::class,array("attr"=>array("class"=>"form-submit btn btn-success")));

        $form -> handleRequest($request);
        if ($form -> isSubmitted()){
            if($form -> isValid()){
                $em=$this->getDoctrine()->getEntityManager();
                $curso_repo=$em->getRepository("PruebaBundle:Curso");
                $curso=$curso_repo ->find($id);
                if(count($curso)!=0){
                    $curso->setCurso($form->get("curso")->getData());
                    $em=$this->getDoctrine()->getEntityManager();
                    $em->persist($curso);
                    $flush=$em->flush();
                    if($flush==null){
                        $status = "El Curso se ha modificado satisfactoriamente";
                    }
                    else{
                        $status = "No se ha modificado Correctamente el curso";
                    }
                }
            }
            else{
                $status = "No se ha modificado Correctamente el curso";
            }
            $this->session->getFlashBag()->add("status",$status);
            $personaCurso=$this->getDoctrine()
            ->getRepository('PruebaBundle:PersonaCurso')
            ->findAll();
            $cursos=$this->getDoctrine()
            ->getRepository('PruebaBundle:Curso')
            ->findAll();

            return $this->redirectToRoute('curso',array(
                "curso" => $cursos,
                "personaCurso" => $personaCurso
            ));
        }
    }



    public function deleteAction($id)
    {
        $cursos=$this->getDoctrine()
            ->getRepository('PruebaBundle:Curso')
            ->find($id);
        $personaCurso=$this ->getDoctrine()
            ->getRepository('PruebaBundle:PersonaCurso')
            ->findOneByCurso($cursos);
        if ($personaCurso!=null){
            $em= $this -> getDoctrine()->getManager();
            $em->remove($personaCurso);
            $em->flush();        
            $this->addFlash(
                    'status',
                    'Curso Retirado'
            );
        }
        return $this->redirectToRoute('curso',array(
                "curso" => $cursos,
                "personaCurso" => $personaCurso
            ));
    }

    public function inscribirAction($id_curso,$id_persona,Request $request)
    {
        $curso=$this->getDoctrine()
            ->getRepository('PruebaBundle:Curso')
            ->find($id_curso);
        $persona=$this->getDoctrine()
            ->getRepository('PruebaBundle:Persona')
            ->find($id_persona);

        $personaCurso=new PersonaCurso();
        
        $personaCurso->setCurso($curso);
        $personaCurso->setPersona($persona);

                    
        $em=$this->getDoctrine()->getEntityManager();
        $em->persist($personaCurso);
        $flush=$em->flush();
        if($flush==null){
            $status = "El Curso se ha Inscrito satisfactoriamente";
        }
        else{
            $status = "No se ha Inscrito Correctamente el curso";
        }
        $this->session->getFlashBag()->add("status",$status);
        $personaCurso=$this->getDoctrine()
            ->getRepository('PruebaBundle:PersonaCurso')
            ->findAll();
        $cursos=$this->getDoctrine()
            ->getRepository('PruebaBundle:Curso')
            ->findAll();

        return $this->redirectToRoute('curso',array(
                "curso" => $cursos,
                "personaCurso" => $personaCurso
            ));
    }
}
