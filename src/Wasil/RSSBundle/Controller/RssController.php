<?php

namespace Wasil\RSSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Wasil\RSSBundle\Entity\Rss;
use Wasil\RSSBundle\Form\RssType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Rss controller.
 *
 */
class RssController extends Controller
{
    /**
     * Lists all Rss entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('WasilRSSBundle:Rss')
            ->createQueryBuilder('r', 'f')
            ->leftJoin('r.feed', 'f')
            ->orderBy('r.pubDate', 'desc')
            ->getQuery()->getResult();

        $feeds = $this->getFeedsList();

        return $this->render(
            'WasilRSSBundle:Rss:index.html.twig', 
            array(
            'rsss'  => $entities,
            'feeds' => $feeds,
            'today' => date("Y-m-d", time()),
            )
        );
    }

    /**
     * Creates a new Rss entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Rss();
        $form = $this->createForm(new RssType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('rss_show', array('id' => $entity->getId())));
        }

        return $this->render('WasilRSSBundle:Rss:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Rss entity.
     *
     */
    public function newAction()
    {
        $entity = new Rss();
        $form   = $this->createForm(new RssType(), $entity);

        return $this->render('WasilRSSBundle:Rss:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Rss entity.
     * @param Rss $rss
     * @return
     */
    public function showAction(Rss $rss)
    {
        if (!$rss) {
            throw $this->createNotFoundException('Unable to find Rss entity.');
        }

        $deleteForm = $this->createDeleteForm($rss->getId());

        return $this->render('WasilRSSBundle:Rss:show.html.twig', array(
            'entity'      => $rss,
            'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Displays a form to edit an existing Rss entity.
     * @param Rss $rss
     * @return
     */
    public function editAction(Rss $rss)
    {
        if (!$rss) {
            throw $this->createNotFoundException('Unable to find Rss entity.');
        }

        $editForm = $this->createForm(new RssType(), $rss);
        $deleteForm = $this->createDeleteForm($rss->getId());

        return $this->render('WasilRSSBundle:Rss:edit.html.twig', array(
            'entity'      => $rss,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Rss entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WasilRSSBundle:Rss')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Rss entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new RssType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('rss_edit', array('id' => $id)));
        }

        return $this->render('WasilRSSBundle:Rss:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Rss entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('WasilRSSBundle:Rss')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Rss entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('rss'));
    }

    /**
     * Creates a form to delete a Rss entity by id.
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

    /**
     * @return mixed
     */
    private function getFeedsList()
    {
        $em = $this->getDoctrine()->getManager();

        return $entities = $em->getRepository('WasilRSSBundle:Feed')
            ->createQueryBuilder('f')
            ->orderBy('f.name', 'asc')
            ->getQuery()->getResult();
    }

    /**
     * @param Rss $rss
     * @param $read
     * @return Response
     */
    public function readAction(Rss $rss, $read)
    {
        $em = $this->getDoctrine()->getManager();

        if (!$rss) {
            throw $this->createNotFoundException('Unable to find Rss entity.');
        }

        $rss->setRead($read);

        $em->persist($rss);
        $em->flush();

        $return=json_encode(true); //json encode the array
        return new Response($return,200,array('Content-Type'=>'application/json'));
}
}
