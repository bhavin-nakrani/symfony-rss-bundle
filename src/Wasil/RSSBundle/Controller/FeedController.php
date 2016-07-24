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
     *
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
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WasilRSSBundle:Feed')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Feed entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('WasilRSSBundle:Feed:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Feed entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WasilRSSBundle:Feed')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Feed entity.');
        }

        $editForm = $this->createForm(new FeedType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('WasilRSSBundle:Feed:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Feed entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WasilRSSBundle:Feed')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Feed entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new FeedType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('feed_edit', array('id' => $id)));
        }

        return $this->render('WasilRSSBundle:Feed:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Feed entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('WasilRSSBundle:Feed')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Feed entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('feed'));
    }

    /**
     * Creates a form to delete a Feed entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
