<?php

namespace PruebaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PruebaBundle\Entity\Persona;
use PruebaBundle\Entity\Curso;
use PruebaBundle\Entity\Telefono;
use PruebaBundle\Entity\PersonaCurso;
use PruebaBundle\Entity\Usuario;
use PruebaBundle\Form\UsuarioType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;


class ReportesController extends Controller
{
    private $session;

    public function __construct(){
        $this->session = new Session();
    }


    public function defaultAction()
    {
        // replace this example code with whatever you need
        $telefono=new Telefono();
        $telefono=$this->getDoctrine()
            ->getRepository('PruebaBundle:Telefono')
            ->findAll();
        
        $persona=new Persona();
        $persona=$this->getDoctrine()
            ->getRepository('PruebaBundle:Persona')
            ->findAll();
        
        $personaCurso=new PersonaCurso();
        $personaCurso=$this->getDoctrine()
            ->getRepository('PruebaBundle:PersonaCurso')
            ->findAll();
        
        return $this->render('PruebaBundle:reportes:default.html.twig',array(
            "telefono" => $telefono,
            "persona" => $persona,
            "personaCurso" => $personaCurso
            ));
    }

    public function reportes_excelAction($name="Excel")
    {
        $personaCurso=new PersonaCurso();
        $personaCurso=$this->getDoctrine()
            ->getRepository('PruebaBundle:PersonaCurso')
            ->findAll();

        if (count($personaCurso)!=0){
            $persona=new Persona();
            $persona=$personaCurso[0]->getPersona();
            $telefono=new Telefono();
            $telefono=$this->getDoctrine()
                ->getRepository('PruebaBundle:Telefono')
                ->findByPersona($persona);
            
            

            $usuario=new Usuario();
            $usuario=$this->getDoctrine()
                ->getRepository('PruebaBundle:Usuario')
                ->findByPersona($persona);

            $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

            $phpExcelObject->getProperties()
                ->setCreator("Ing. Luis Barrios")
                ->setTitle("Exportando a excel")
                ->setSubject("Reporte")
                ->setDescription("Reporte");

            $phpExcelObject->setActiveSheetIndex(0);
            $phpExcelObject->getActiveSheet()->setTitle('Reporte');
            
            $phpExcelObject->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Nombre de Usuario:')
                ->setCellValue('B1', 'Nombre de la Persona:')
                ->setCellValue('C1', 'Correo:')
                ->setCellValue('D1', 'Telefonos:')
                ->setCellValue('E1', 'Cursos Inscritos:');

            $phpExcelObject->setActiveSheetIndex(0)
                ->getColumnDimension('A')
                ->setWidth(30);
            $phpExcelObject->setActiveSheetIndex(0)
                ->getColumnDimension('B')
                ->setWidth(30);
            $phpExcelObject->setActiveSheetIndex(0)
                ->getColumnDimension('C')
                ->setWidth(30);
            $phpExcelObject->setActiveSheetIndex(0)
                ->getColumnDimension('D')
                ->setWidth(30);
            $phpExcelObject->setActiveSheetIndex(0)
                ->getColumnDimension('E')
                ->setWidth(30);

            // recorremos los registros obtenidos de la consulta a base de datos escribiéndolos en las celdas correspondientes
            $row = 2;
            foreach ($usuario as $item) {
                $phpExcelObject->setActiveSheetIndex(0)
                    ->setCellValue('A'.$row, $item->getNombre());

                $row++;
            }
            
            $phpExcelObject->setActiveSheetIndex(0)
                ->setCellValue('B2', $persona->getNombre());

            $row = 2;
            foreach ($usuario as $item) {
                $phpExcelObject->setActiveSheetIndex(0)
                    ->setCellValue('C2', $usuario[0]->getCorreo());
                $row++;
            }

            

            $row = 2;
            foreach ($telefono as $item) {
                $phpExcelObject->setActiveSheetIndex(0)
                    ->setCellValue('D'.$row, $item->getTelefono());
                $row++;
            }
            $row = 2;
            foreach ($personaCurso as $item) {
                $phpExcelObject->setActiveSheetIndex(0)
                    ->setCellValue('E'.$row, $item->getCurso()->getCurso());

                $row++;
            }

            // se crea el writer
            $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
            // se crea el response
            $response = $this->get('phpexcel')->createStreamedResponse($writer);
            // y por último se añaden las cabeceras
            $dispositionHeader = $response->headers->makeDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                'reporte.xls'
            );
            $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
            $response->headers->set('Pragma', 'public');
            $response->headers->set('Cache-Control', 'maxage=1');
            $response->headers->set('Content-Disposition', $dispositionHeader);

            return $response;
        }
        else{
            $status = "No tiene Cursos Inscritos";
            $this->session->getFlashBag()->add("status",$status);
            return $this->render('PruebaBundle:reportes:default.html.twig');
        }
    }

    public function reportes_pdfAction($name="Pdf")
    {
        $personaCurso=new PersonaCurso();
        $personaCurso=$this->getDoctrine()
            ->getRepository('PruebaBundle:PersonaCurso')
            ->findAll();

        if (count($personaCurso)!=0){
            $persona=new Persona();
            $persona=$personaCurso[0]->getPersona();
            $telefono=new Telefono();
            $telefono=$this->getDoctrine()
                ->getRepository('PruebaBundle:Telefono')
                ->findByPersona($persona);
            
            

            $usuario=new Usuario();
            $usuario=$this->getDoctrine()
                ->getRepository('PruebaBundle:Usuario')
                ->findByPersona($persona);

            $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

            $phpExcelObject->getProperties()
                ->setCreator("Ing. Luis Barrios")
                ->setTitle("Exportando a excel")
                ->setSubject("Reporte")
                ->setDescription("Reporte");

            $phpExcelObject->setActiveSheetIndex(0);
            $phpExcelObject->getActiveSheet()->setTitle('Reporte');
            
            $phpExcelObject->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Nombre de Usuario:')
                ->setCellValue('B1', 'Nombre de la Persona:')
                ->setCellValue('C1', 'Correo:')
                ->setCellValue('D1', 'Telefonos:')
                ->setCellValue('E1', 'Cursos Inscritos:');

            $phpExcelObject->setActiveSheetIndex(0)
                ->getColumnDimension('A')
                ->setWidth(30);
            $phpExcelObject->setActiveSheetIndex(0)
                ->getColumnDimension('B')
                ->setWidth(30);
            $phpExcelObject->setActiveSheetIndex(0)
                ->getColumnDimension('C')
                ->setWidth(30);
            $phpExcelObject->setActiveSheetIndex(0)
                ->getColumnDimension('D')
                ->setWidth(30);
            $phpExcelObject->setActiveSheetIndex(0)
                ->getColumnDimension('E')
                ->setWidth(30);

            // recorremos los registros obtenidos de la consulta a base de datos escribiéndolos en las celdas correspondientes
            $row = 2;
            foreach ($usuario as $item) {
                $phpExcelObject->setActiveSheetIndex(0)
                    ->setCellValue('A'.$row, $item->getNombre());

                $row++;
            }
            
            $phpExcelObject->setActiveSheetIndex(0)
                ->setCellValue('B2', $persona->getNombre());

            $row = 2;
            foreach ($usuario as $item) {
                $phpExcelObject->setActiveSheetIndex(0)
                    ->setCellValue('C2', $usuario[0]->getCorreo());
                $row++;
            }

            

            $row = 2;
            foreach ($telefono as $item) {
                $phpExcelObject->setActiveSheetIndex(0)
                    ->setCellValue('D'.$row, $item->getTelefono());
                $row++;
            }
            $row = 2;
            foreach ($personaCurso as $item) {
                $phpExcelObject->setActiveSheetIndex(0)
                    ->setCellValue('E'.$row, $item->getCurso()->getCurso());

                $row++;
            }

            $phpExcelObject->setActiveSheetIndex(0);

            $rendererName = \PHPExcel_Settings::PDF_RENDERER_MPDF;
            $rendererLibrary = 'mPDF';
            $rendererLibraryPath = dirname(__FILE__).'/../../../vendor/mpdf/mpdf';

            if (!\PHPExcel_Settings::setPdfRenderer(
                $rendererName,
                $rendererLibraryPath
            )) {
                die(
                    'NOTICE: Please set the $rendererName and $rendererLibraryPath values' .
                    '<br />' .
                    'at the top of this script as appropriate for your directory structure'
                );
            }
            // Crea el writer
            $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'PDF');
            // Envia la respuesta del controlador
            $response = $this->get('phpexcel')->createStreamedResponse($writer);
            // Agrega los headers requeridos
            $dispositionHeader = $response->headers->makeDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                'ReportePersonas.pdf'
            );

            $response->headers->set('Content-Type', 'application/pdf');
            $response->headers->set('Pragma', 'public');
            $response->headers->set('Cache-Control', 'maxage=0');
            $response->headers->set('Content-Disposition', $dispositionHeader);

            return $response;

        }
        else{
            $status = "No tiene Cursos Inscritos";
            $this->session->getFlashBag()->add("status",$status);
            return $this->render('PruebaBundle:reportes:default.html.twig');
        }
    }
}
