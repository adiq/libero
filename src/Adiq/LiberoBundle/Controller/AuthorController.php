<?php

namespace Adiq\LiberoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Adiq\LiberoBundle\Entity\Author;
use Adiq\LiberoBundle\Form\AuthorType;

/**
 * Author controller.
 *
 * @Route("/author")
 */
class AuthorController extends Controller
{

    /**
     * Lists all Author entities.
     *
     * @Route("/", name="author")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdiqLiberoBundle:Author')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Author entity.
     *
     * @Route("/", name="author_create")
     * @Method("POST")
     * @Template("AdiqLiberoBundle:Author:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Author();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('author'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Author entity.
     *
     * @param Author $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Author $entity)
    {
        $form = $this->createForm(new AuthorType(), $entity, array(
            'action' => $this->generateUrl('author_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Utwórz'));

        return $form;
    }

    /**
     * Displays a form to create a new Author entity.
     *
     * @Route("/new", name="author_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Author();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Author entity.
     *
     * @Route("/{id}/edit", name="author_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdiqLiberoBundle:Author')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Author entity.');
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
    * Creates a form to edit a Author entity.
    *
    * @param Author $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Author $entity)
    {
        $form = $this->createForm(new AuthorType(), $entity, array(
            'action' => $this->generateUrl('author_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Aktualizuj'));

        return $form;
    }
    /**
     * Edits an existing Author entity.
     *
     * @Route("/{id}", name="author_update")
     * @Method("PUT")
     * @Template("AdiqLiberoBundle:Author:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdiqLiberoBundle:Author')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Author entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('author_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Author entity.
     *
     * @Route("/{id}", name="author_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdiqLiberoBundle:Author')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Author entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('author'));
    }

    /**
     * Creates a form to delete a Author entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('author_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Usuń'))
            ->getForm()
        ;
    }
}
