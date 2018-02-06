<?php

namespace AppBundle\Controller;

use AppBundle\Entity\EntrepriseTest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Entreprisetest controller.
 *
 * @Route("entreprisetest")
 */
class EntrepriseTestController extends Controller
{
    /**
     * Lists all entrepriseTest entities.
     *
     * @Route("/", name="entreprisetest_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entrepriseTests = $em->getRepository('AppBundle:EntrepriseTest')->findAll();

        //$recherche = $em->getRepository('AppBundle:EntrepriseTest')->findBy($form->getData()->toArray());
        

        return $this->render('entreprisetest/index.html.twig', array(
            'entrepriseTests' => $entrepriseTests,
            'recherche'=> $recherche,
        ));

    }

    /**
     * Creates a new entrepriseTest entity.
     *
     * @Route("/new", name="entreprisetest_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $entrepriseTest = new Entreprisetest();
        $form = $this->createForm('AppBundle\Form\EntrepriseTestType', $entrepriseTest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entrepriseTest);
            $em->flush();

            return $this->redirectToRoute('entreprisetest_show', array('id' => $entrepriseTest->getId()));
        }

        return $this->render('entreprisetest/new.html.twig', array(
            'entrepriseTest' => $entrepriseTest,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a entrepriseTest entity.
     *
     * @Route("/{id}", name="entreprisetest_show")
     * @Method("GET")
     */
    public function showAction(EntrepriseTest $entrepriseTest)
    {
        $deleteForm = $this->createDeleteForm($entrepriseTest);

        return $this->render('entreprisetest/show.html.twig', array(
            'entrepriseTest' => $entrepriseTest,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing entrepriseTest entity.
     *
     * @Route("/{id}/edit", name="entreprisetest_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, EntrepriseTest $entrepriseTest)
    {
        $deleteForm = $this->createDeleteForm($entrepriseTest);
        $editForm = $this->createForm('AppBundle\Form\EntrepriseTestType', $entrepriseTest);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('entreprisetest_edit', array('id' => $entrepriseTest->getId()));
        }

        return $this->render('entreprisetest/edit.html.twig', array(
            'entrepriseTest' => $entrepriseTest,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a entrepriseTest entity.
     *
     * @Route("/{id}", name="entreprisetest_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, EntrepriseTest $entrepriseTest)
    {
        $form = $this->createDeleteForm($entrepriseTest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entrepriseTest);
            $em->flush();
        }

        return $this->redirectToRoute('entreprisetest_index');
    }

    /**
     * Creates a form to delete a entrepriseTest entity.
     *
     * @param EntrepriseTest $entrepriseTest The entrepriseTest entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EntrepriseTest $entrepriseTest)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('entreprisetest_delete', array('id' => $entrepriseTest->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


}
