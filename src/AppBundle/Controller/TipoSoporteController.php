<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TipoSoporte;
use AppBundle\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Tiposoporte controller.
 *  
 * @Route("/admin/tiposoporte")
 */
class TipoSoporteController extends Controller
{
    /**
     * Lists all tipoSoporte entities.
     *
     * @Route("/", name="tiposoporte_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
 
        $tipoSoportes = $em->getRepository('AppBundle:TipoSoporte')->findAll();
    
        

        return $this->render('tiposoporte/index.html.twig', array(
            'tipoSoportes' => $tipoSoportes,
            
        ));
    }

    /**
     * Creates a new tipoSoporte entity.
     *
     * @Route("/new", name="tiposoporte_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tipoSoporte = new Tiposoporte();
        $usuario = new usuario();
        $form = $this->createForm('AppBundle\Form\TipoSoporteType', $tipoSoporte);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $usuario = $this->getUser(); 
            $tipoSoporte->setUsuario($usuario);
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoSoporte);
            $em->flush();

            return new JsonResponse(array("status" => "200"));
        }

        return $this->render('tiposoporte/new.html.twig', array(
            'tipoSoporte' => $tipoSoporte,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a tipoSoporte entity.
     *
     * @Route("/{id}", name="tiposoporte_show")
     * @Method("GET")
     */
    public function showAction(TipoSoporte $tipoSoporte)
    {
        $deleteForm = $this->createDeleteForm($tipoSoporte);

        return $this->render('tiposoporte/show.html.twig', array(
            'tipoSoporte' => $tipoSoporte,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tipoSoporte entity.
     *
     * @Route("/{id}/edit", name="tiposoporte_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TipoSoporte $tipoSoporte)
    {
        $deleteForm = $this->createDeleteForm($tipoSoporte);
        $editForm = $this->createForm('AppBundle\Form\TipoSoporteType', $tipoSoporte);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(array("status" => "200"));
        }

        return $this->render('tiposoporte/edit.html.twig', array(
            'tipoSoporte' => $tipoSoporte,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tipoSoporte entity.
     *
     * @Route("tiposoporte/{id}", name="tiposoporte_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TipoSoporte $tipoSoporte)
    {
        $form = $this->createDeleteForm($tipoSoporte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tipoSoporte);
            $em->flush();
        }

        return $this->redirectToRoute('tiposoporte_index');
    }

    /**
     * Creates a form to delete a tipoSoporte entity.
     *
     * @param TipoSoporte $tipoSoporte The tipoSoporte entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TipoSoporte $tipoSoporte)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tiposoporte_delete', array('id' => $tipoSoporte->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
