<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Soporte;
use AppBundle\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Soporte controller.
 *
 * @Route("soporte")
 */
class SoporteController extends Controller
{
    /**
     * Lists all soporte entities.
     *
     * @Route("/", name="mis_soportes")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $this->getUser(); 
        $idUsuario = $usuario->getId();
        $soportes = $em->getRepository('AppBundle:Soporte')->findBy(['idUsuario' => $idUsuario]);

        return $this->render('soporte/index.html.twig', array(
            'soportes' => $soportes,
        ));
    }

    /**
     * Creates a new soporte entity.
     *
     * @Route("/new", name="soporte_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $soporte = new Soporte();
        $usuario = new usuario();
        $form = $this->createForm('AppBundle\Form\SoporteType', $soporte);
        $form->handleRequest($request);

        if($request->isXmlHttpRequest()){
            $status = "";
            
          if ($form->isSubmitted() && $form->isValid()) {

                $usuario = $this->getUser(); 
                $soporte->setUsuario($usuario);
                $em = $this->getDoctrine()->getManager();
                $em->persist($soporte);
                $em->flush();
                $status = 200;
              // ... do any other work - like sending them an email, etc
              // maybe set a "flash" success message for the user
               return new JsonResponse(array('status' => $status, 'soporteRegistrado'=> $soporte->getId()));
              //return $this->redirectToRoute('replace_with_some_route');
          }else if ($form->isSubmitted() && !$form->isValid()){
                    $errors = [];
                    $status = 400;
            
                    $validator = $this->get('validator');
                    $errorsValidator = $validator->validate($soporte);
                    foreach ($errorsValidator as $error) {
                    $valor = $error->getPropertyPath();
                    $errors += ["$valor" => $error->getMessage()];
                
            }
            return new JsonResponse($errors);    
         
          }
        }
        return $this->render(
            'soporte/new.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * Finds and displays a soporte entity.
     *
     * @Route("/{id}", name="soporte_show")
     * @Method("GET")
     */
    public function showAction(Soporte $soporte)
    {
        $deleteForm = $this->createDeleteForm($soporte);

        return $this->render('soporte/show.html.twig', array(
            'soporte' => $soporte,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing soporte entity.
     *
     * @Route("/{id}/edit", name="soporte_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Soporte $soporte)
    {
        $deleteForm = $this->createDeleteForm($soporte);
        $editForm = $this->createForm('AppBundle\Form\SoporteType', $soporte);

        
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('soporte_edit', array('id' => $soporte->getId()));
        }

        return $this->render('soporte/edit.html.twig', array(
            'soporte' => $soporte,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a soporte entity.
     *
     * @Route("soporte/{id}", name="soporte_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Soporte $soporte)
    {
        $form = $this->createDeleteForm($soporte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($soporte);
            $em->flush();
        }

        return $this->redirectToRoute('soporte_index');
    }

    /**
     * Creates a form to delete a soporte entity.
     *
     * @param Soporte $soporte The soporte entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Soporte $soporte)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('soporte_delete', array('id' => $soporte->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

   
}
