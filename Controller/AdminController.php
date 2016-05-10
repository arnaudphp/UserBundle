<?php

namespace Leoo\UserBundle\Controller;

use Leoo\UserBundle\Entity\UserOne;
use Leoo\UserBundle\EventListener\SyncUserEvent;
use Leoo\UserBundle\EventListener\SyncUserListener;
use Leoo\UserBundle\EventListener\UserCreateEvent;
use Leoo\UserBundle\EventListener\UserDeleteEvent;
use Leoo\UserBundle\EventListener\UserEvent;
use Leoo\UserBundle\EventListener\UserUpdateEvent;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
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
    public function indexAction(Request $request)
    {
        if ($request->query->has('page'))  {
            $page = $request->query->get('page');
        } else {
            $page = 1;
        }

        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('LeooUserBundle:User')->findAll();

        $adapter = new ArrayAdapter($users);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(3); // 10 by default
        $pagerfanta->setCurrentPage($page); // 1 by default


        return $this->render('LeooUserBundle:User:index.html.twig', array(
            'users' => $users,
            'my_pager' => $pagerfanta,
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

            $event = new UserEvent($user);
            $this
                ->get('event_dispatcher')
                ->dispatch(SyncUserListener::onUserCreate, $event)
            ;

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

            $event = new UserEvent($user);
            $this
                ->get('event_dispatcher')
                ->dispatch(SyncUserListener::onUserUpdate, $event)
            ;

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

            $event = new UserEvent($user);
            $this
                ->get('event_dispatcher')
                ->dispatch(SyncUserListener::onUserDelete, $event)
            ;

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

    public function enableAction(User $user)
    {
        $user->setEnabled(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $event = new UserEvent($user);
        $this
            ->get('event_dispatcher')
            ->dispatch(SyncUserListener::onUserEnable, $event)
        ;

        return $this->redirectToRoute('user_index');
    }

    public function disableAction(User $user)
    {
        $user->setEnabled(false);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $event = new UserEvent($user);
        $this
            ->get('event_dispatcher')
            ->dispatch(SyncUserListener::onUserDisable, $event)
        ;

        return $this->redirectToRoute('user_index');
    }
}
