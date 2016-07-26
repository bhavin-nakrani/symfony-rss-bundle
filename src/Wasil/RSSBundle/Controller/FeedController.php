<?php

namespace Wasil\RSSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Wasil\RSSBundle\Entity\Feed;
use Wasil\RSSBundle\Form\FeedType;

/**
 * Feed controller.
 *
 */
class FeedController extends Controller
{
    /**
     * Lists all Feed entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('WasilRSSBundle:Feed')->findAll();

        return $this->render('WasilRSSBundle:Feed:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Feed entity.
     * @param Request $request
     * @return
     */
    public function createAction(Request $request)
    {
        $entity  = new Feed();
        $form = $this->createForm(new FeedType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('feed_show', array('id' => $entity->getId())));
        }

        return $this->render('WasilRSSBundle:Feed:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Feed entity.
     *
     */
    public function newAction()
    {
        $entity = new Feed();
        $form   = $this->createForm(new FeedType(), $entity);

        return $this->render('WasilRSSBundle:Feed:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Feed entity.
     * @param Feed $feed
     * @return
     */
    public function showAction(Feed $feed)
    {
        $deleteForm = $this->createDeleteForm($feed);

        return $this->render('WasilRSSBundle:Feed:show.html.twig', array(
            'entity'      => $feed,
            'delete_form' => $deleteForm->createView()));
    }

    /**
     * Displays a form to edit an existing Feed entity.
     * @param Feed $feed
     * @return
     */
    public function editAction(Feed $feed)
    {
        $editForm = $this->createForm(new FeedType(), $feed);
        $deleteForm = $this->createDeleteForm($feed);

        return $this->render('WasilRSSBundle:Feed:edit.html.twig', array(
            'entity'      => $feed,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Feed entity.
     * @param Request $request
     * @param Feed $feed
     * @return
     */
    public function updateAction(Request $request, Feed $feed)
    {
        $em = $this->getDoctrine()->getManager();

        $deleteForm = $this->createDeleteForm($feed);
        $editForm = $this->createForm(new FeedType(), $feed);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($feed);
            $em->flush();

            return $this->redirect($this->generateUrl('feed_edit', array('id' => $feed->getId())));
        }

        return $this->render('WasilRSSBundle:Feed:edit.html.twig', array(
            'entity'      => $feed,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Feed entity.
     * @param Request $request
     * @param Feed $feed
     * @return
     */
    public function deleteAction(Request $request, Feed $feed)
    {
        $form = $this->createDeleteForm($feed);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($feed);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('feed'));
    }

    /**
     * Creates a form to delete a Feed entity by id.
     *
     * @param Feed $feed
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Feed $feed)
    {
        return $this->createFormBuilder(array('id' => $feed->getId()))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
