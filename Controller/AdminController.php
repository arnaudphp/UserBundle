<?php

namespace Leoo\UserBundle\Controller;

use Leoo\UserBundle\Entity\UserOne;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Leoo\UserBundle\Entity\User;
use Leoo\UserBundle\Form\UserType;

/**
 * User controller.
 *
 */
class AdminController extends Controller
{
    /**
     * Lists all User entities.
     *
     */
    public function indexAction()
    {

        $user = $this->getUser();

            dump($user);
/*

        $discriminator = $this->container->get('pugx_user.manager.user_discriminator');
        $discriminator->setClass('Leoo\UserBundle\Entity\UserOne');

        $userManager = $this->container->get('pugx_user_manager');

        $userOne = $userManager->createUser();

        $userOne->setUsername('addddeemdidn2');
        $userOne->setEmail('addedddemdin2@mail.com');
        $userOne->setPlainPassword('123456');
        $userOne->setEnabled(true);
        $userOne->setIdentifier(24);
        $userOne->setUsernamedd('damienlasserre');

        $userManager->updateUser($userOne, true);
        dump($userOne);




        $discriminator = $this->container->get('pugx_user.manager.user_discriminator');
        $discriminator->setClass('Leoo\UserBundle\Entity\UserTwo');

        $userManager = $this->container->get('pugx_user_manager');

        $userTwo = $userManager->createUser();

        $userTwo->setUsername('adm"zdidden2');
        $userTwo->setEmail('addmdidezzn2@mail.com');
        $userTwo->setPlainPassword('123456');
        $userTwo->setEnabled(true);
        $userTwo->setIdentifier(24);
        $userTwo->setTest('colone de test');

        $userManager->updateUser($userTwo, true);
        dump($userTwo);

        die('ok');

        */
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('LeooUserBundle:User')->findAll();


        return $this->render('LeooUserBundle:User:index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Creates a new User entity.
     *
     */
    public function newAction(Request $request)
    {
        $user = new UserOne();
        $form = $this->createForm(new UserType(), $user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_show', array('id' => $user->getId()));
        }

        return $this->render('LeooUserBundle:user:new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a User entity.
     *
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('LeooUserBundle:user:show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @param Request $request
     * @param User $user
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm(new UserType() , $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
        }

        return $this->render('LeooUserBundle:user:edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a User entity.
     *
     * @param Request $request
     * @param User $user
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * Creates a form to delete a User entity.
     *
     * @param User $user The User entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
