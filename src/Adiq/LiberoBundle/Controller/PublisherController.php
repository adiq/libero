<?php

namespace Adiq\LiberoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Adiq\LiberoBundle\Entity\Publisher;
use Adiq\LiberoBundle\Form\PublisherType;

/**
 * Publisher controller.
 *
 * @Route("/publisher")
 */
class PublisherController extends Controller
{

    /**
     * Lists all Publisher entities.
     *
     * @Route("/", name="publisher")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdiqLiberoBundle:Publisher')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Publisher entity.
     *
     * @Route("/", name="publisher_create")
     * @Method("POST")
     * @Template("AdiqLiberoBundle:Publisher:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Publisher();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('publisher'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Publisher entity.
     *
     * @param Publisher $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Publisher $entity)
    {
        $form = $this->createForm(new PublisherType(), $entity, array(
            'action' => $this->generateUrl('publisher_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Utwórz'));

        return $form;
    }

    /**
     * Displays a form to create a new Publisher entity.
     *
     * @Route("/new", name="publisher_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Publisher();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Publisher entity.
     *
     * @Route("/{id}/edit", name="publisher_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdiqLiberoBundle:Publisher')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publisher entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Publisher entity.
    *
    * @param Publisher $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Publisher $entity)
    {
        $form = $this->createForm(new PublisherType(), $entity, array(
            'action' => $this->generateUrl('publisher_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Aktualizuj'));

        return $form;
    }
    /**
     * Edits an existing Publisher entity.
     *
     * @Route("/{id}", name="publisher_update")
     * @Method("PUT")
     * @Template("AdiqLiberoBundle:Publisher:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdiqLiberoBundle:Publisher')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publisher entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('publisher_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Publisher entity.
     *
     * @Route("/{id}", name="publisher_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdiqLiberoBundle:Publisher')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Publisher entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('publisher'));
    }

    /**
     * Creates a form to delete a Publisher entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('publisher_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Usuń'))
            ->getForm()
        ;
    }
}
