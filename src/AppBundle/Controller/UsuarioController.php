<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Entity\Soporte;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\FormInterface;


/**
 * Usuario controller.
 *
 * 
 */
class UsuarioController extends Controller
{
    /**
     * Lists all usuario entities.
     *
     * @Route("/admin/list", name="lista_usuarios")
     * @Method({"GET", "POST"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $usuario = $em->getRepository('AppBundle:Usuario')->findAll();

        return $this->render('usuario/listaUsuarios.html.twig', array(
            'usuario' => $usuario,
        ));
    }

    /**
     *
     * @Route("/admin/soportesAdmin", name="soportes_admin")
     * @Method({"GET", "POST"})
     */
    public function soportesAdminAction()
    {
        $em = $this->getDoctrine()->getManager();

        $soportes = $em->getRepository('AppBundle:Usuario')->listarTodo();

        return $this->render('usuario/indexAdmin.html.twig', array(
            'soportes' => $soportes,
        ));
    }

     /**
     *
     * @Route("/admin/revisarSoporte", name="revisar_soporte")
     * @Method({"GET", "POST"})
     */
    public function revisarSoporteAction(Request $request)
    {
        
         
         if($request->isXmlHttpRequest()){
           
            $soporteId = $request->request->get('id');
            
    
            $em = $this->getDoctrine()->getManager();
            $soporte = $em->getRepository('AppBundle:Soporte')->find($soporteId);

            return new JsonResponse(array('id' => $soporte->getId(),
                                         'asunto' => $soporte->getAsunto(),
                                         'descripcion' => $soporte->getDescripcion(),
                                         'prioridad' => $soporte->getPrioridad(),
                                         'descripcionSolucion' => $soporte->getDescripcionSolucion(),
                                         'estado' => $soporte->getEstado(),
                                         'idUsuario' => $soporte->getIdUsuario(),
                                         'idTipoSoporte' => $soporte->getIdTipoSoporte(),

                                        ));
        }else{
            return new JsonResponse('error');

        }
        


        
    }

     /**
     *
     * @Route("/admin/guardarSoporte", name="guardar_soporte")
     * @Method({"GET", "POST"})
     */
    public function guardarSoporteAction(Request $request)
    {   
        
        if($request->isXmlHttpRequest()){
            $id = $request->request->get('id');
            $em = $this->getDoctrine()->getManager();
            $soporte = $em->getRepository('AppBundle:Soporte')->find($id);
            if (!$soporte) {

                throw $this->createNotFoundException(
                    'no existe el soporte con id'.$id
                );
            }

            $soporteAsunto = $request->request->get('asunto');
            $soporte->setAsunto($soporteAsunto);

            $descripcion = $request->request->get('descripcion');
            $soporte->setDescripcion($descripcion);

            $prioridad = $request->request->get('prioridad');
            $soporte->setPrioridad($prioridad);

            $estado = $request->request->get('estado');
            $soporte->setEstado($estado);

            $descripcionSolucion = $request->request->get('descripcionSolucion');
            $soporte->setDescripcionSolucion($descripcionSolucion);
           
            //$idUsuario = $request->request->get('idUsuario');
           // $usuario = $this->getDoctrine()->getRepository('AppBundle:Usuario')->find($idUsuario);
            //var_dump($usuario);
            //die();
            //$soporte->setUsuario($usuario);

            //$idTipoSoporte = $request->request->get('idTipoSoporte');
            //$TipoSoporte = $this->getDoctrine()->getRepository('AppBundle:TipoSoporte')->find($idTipoSoporte);
            //var_dump($usuario);
            //die();
            //$soporte->setTipoSoporte($TipoSoporte);

            $em->flush();

            return new JsonResponse(array("status" => "200"));
        }

        return new JsonResponse(array("status" => "400"));

    }

    
    /**
     *
     * @Route("/admin", name="clientes")
     *
     */
    public function clientesAction()
    {
         return $this->render('default/index.html.twig');
    }

    /**
     * Creates a new usuario entity.
     *
     * @Route("/admin/new", name="usuario_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $usuario = new Usuario();
        $form = $this->createForm('AppBundle\Form\UsuarioType', $usuario);
        $form->handleRequest($request);
              
        if ($form->isSubmitted() && $form->isValid()) {
            
            //se encrypta el password y se fija el plainpassword en password
            $password = $passwordEncoder->encodePassword($usuario, $usuario->getPlainPassword());
            $usuario->setPassword($password);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();

            return new JsonResponse(array("status" => "200"));
        }

        return $this->render('usuario/new.html.twig', array(
            'usuario' => $usuario,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Usuario entity.
     *
     * @Route("/admin/{id}", name="usuario_show")
     * @Method("GET")
     */
    public function showAction(Usuario $usuario, UserPasswordEncoderInterface $passwordEncoder)
    {
        $deleteForm = $this->createDeleteForm($usuario);
        
        $password = $passwordEncoder->encodePassword($usuario, $usuario->getPlainPassword());
        $usuario->setPassword($password);

        return $this->render('usuario/show.html.twig', array(
            'usuario' => $usuario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     *
     * @Route("/admin/{id}/edit", name="usuario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Usuario $usuario)
    {
        $deleteForm = $this->createDeleteForm($usuario);
        $editForm = $this->createForm('AppBundle\Form\UsuarioType', $usuario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(array("status" => "200"));
        }

        return $this->render('usuario/edit.html.twig', array(
            'usuario' => $usuario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));


        
    }

    /**
     * Deletes a usuario entity.
     *
     * @Route("/admin/usuario/{id}", name="usuario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Usuario $usuario)
    {
        $form = $this->createDeleteForm($usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($usuario);
            $em->flush();
        }

        return $this->redirectToRoute('usuario_index');
    }

    /**
     * Creates a form to delete a usuario entity.
     *
     * @param Usuario $usuario The usuario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Usuario $usuario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usuario_delete', array('id' => $usuario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
  
    
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render('usuario/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
    
    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
    }

    /**
     * @Route("/reporteCliente", name="reporte_cliente")
     */
    public function reportePorClienteAction()
    {
        $em = $this->getDoctrine()->getManager();
        $reporte = $em->getRepository('AppBundle:Usuario')->soportesPorCliente();

        return $this->render('usuario/reporteCliente.html.twig', array('reporte' => $reporte));

    }

    /**
     * @Route("/reporteTipoSoporte", name="reporte_tipoSoporte")
     */
    public function reportePorTipoSoporteAction()
    {
        $em = $this->getDoctrine()->getManager();
        $reporte = $em->getRepository('AppBundle:Usuario')->soportesPorTipoSoporte();

        return $this->render('usuario/reporteTipoSoporte.html.twig', array('reporte' => $reporte));

    }

    /**
     * @Route("/buscar", name="buscar")
     */
    public function BuscarSoportesAction(request $request)
    {
        if($request->isXmlHttpRequest()){
           
        $nombre = $request->request->get('nombre');
        $em = $this->getDoctrine()->getManager();
        $resultado = $em->getRepository('AppBundle:Usuario')->buscarSoportesCliente($nombre);
            if($resultado != null){
                return $this->render('usuario/resultadoBusqueda.html.twig', array('soportes' => $resultado));
            }else{
                return new JsonResponse(array("status" => "400"));
            }

        }
        

        

    }
}
