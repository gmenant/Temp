<?php

namespace AppBundle\Controller;

use Symfony\Component\Form\FormBuilderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\EntrepriseTest;
use AppBundle\Form\RechercheType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/entreprise")
 */
class EntrepriseTest2Controller extends Controller
{
    /**
     * @Route("/add", name="add_entreprise")
     */
      public function addAction(Request $request)
      {
        $siretAleatoire = rand (100000000,999999999 );
        // Création de l'entité
        $LaBoiteDuCoin = new EntrepriseTest();
        $LaBoiteDuCoin->setNom('LaBoiteDuCoin');
        $LaBoiteDuCoin->setSiret($siretAleatoire);
        $LaBoiteDuCoin->setCommentaire("Une boite qu'elle est bien");
        // On peut ne pas définir ni la date ni la publication,
        // car ces attributs sont définis automatiquement dans le constructeur

        $em = $this->getDoctrine()->getManager();

        $em->persist($LaBoiteDuCoin);

        $em->flush();
        $mess = "Ben normalement, c'est ajouté à la BDD";

        return $this->render('/entreprisetest2/Envoie.html.twig', array(
               'mess' => $mess,
            ));     
          }



    /**
     * @Route("/search", name="search_entreprise")
     */
      public function searchAction(Request $request)
      {

        $form = $this->createForm('AppBundle\Form\RechercheType');
        $form->handleRequest($request);
        $mess = "Recherche";

        /* On regarde si le formulaire a été soumis */

        if ($form->isSubmitted() && $form->isValid()) {
                $data = $request->request->get('appbundle_recherche');
                dump($data['mot_cle']);

                $em = $this->getDoctrine()->getManager();
                $test = $em->getRepository('AppBundle:EntrepriseTest')->findByMotCle1($data['mot_cle']);
                dump($test);

                return $this->render('/entreprisetest2/Envoie.html.twig', array(
                   'result' => $test,
                   'mess' => $mess,
                   'form' => $form->createView(),
                )); 
            }

        /* Si c'est la cas, je récupère le mot clé saisie */
        /* Puis je fais une requète de type like pour récupérer les enterprises qui contiennent le mots clés saisies */
        $mess = "Rien d'entré";
        return $this->render('/entreprisetest2/Envoie.html.twig', array(
               'mess' => $mess,
               'form' => $form->createView(),
            ));     
          }



    /**
     * @Route("/create", name="create_entreprise")
     */
      public function createAction(Request $request)
      {
        $entreprise = new EntrepriseTest();
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $entreprise);
        $formBuilder
          ->add('nom',      TextType::class)
          ->add('siret',     TextType::class)
          ->add('commentaire',   TextareaType::class)
          ->add('save',      SubmitType::class)
            ;   

        $form = $formBuilder->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
                if ($form->isValid()) {
                    $em = $this->getDoctrine()->getManager();

                    $em->persist($entreprise);
                    $em->flush();

                    $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
                    return $this->redirectToRoute('search_entreprise');   
                }

        }

        return $this->render('entreprisetest2/creation.html.twig', array(
              'form' => $form->createView(),
            ));
       }

       /**
     * @Route("/delete", name="delete_entreprise")
     */
      public function deleteAction(Request $request)
      {

        $form = $this->createForm('AppBundle\Form\DeleteType');
        $form->handleRequest($request);
        $mess = "Recherche";

        /* On regarde si le formulaire a été soumis */

        if ($form->isSubmitted() && $form->isValid()) {
                $data = $request->request->get('appbundle_recherche');
                dump($data['mot_cle']);

                $em = $this->getDoctrine()->getManager();
                $test = $em->getRepository('AppBundle:EntrepriseTest')->deleteEntry($data['mot_cle']);
                dump($test);

                return $this->render('/entreprisetest2/Envoie.html.twig', array(
                   'result' => $test,
                   'mess' => $mess,
                   'form' => $form->createView(),
                )); 
            }

        /* Si c'est la cas, je récupère le mot clé saisie */
        /* Puis je fais une requète de type like pour récupérer les enterprises qui contiennent le mots clés saisies */
        $mess = "Rien d'entré";
        return $this->render('/entreprisetest2/Envoie.html.twig', array(
               'mess' => $mess,
               'form' => $form->createView(),
            ));     
          }






    /**
     * @Route("/delete", name="delete_entreprise")
     */
     /* public function deleteAction(Request $request)
      {
        $entreprise = new EntrepriseTest();
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $entreprise);
        $formBuilder
          ->add('nom', ChoiceType::class, [
                'choice_label' => function($entreprise, $key, $index) {
        /** @var entrepriseTest $entrepriseTest *//*
                    return $entrepriseTest->getNom();
                }]
            )
            ->add('delete', SubmitType::class)
          ; 


        $form = $formBuilder->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
                if ($form->isValid()) {
                    $data = $request->request->get('appbundle_recherche');
                    $em = $this->getDoctrine()->getManager();
                    $em->getRepository('AppBundle:EntrepriseTest')->deleteEntry($data['mot_cle']);
                    $em->persist($entreprise);
                    $em->flush();

                    $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
                    return $this->redirectToRoute('search_entreprise');   
                }

        }

        return $this->render('entreprisetest2/creation.html.twig', array(
              'form' => $form->createView(),
            ));
       }*/


}


