<?php

namespace Adiq\LiberoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Adiq\LiberoBundle\Entity\Action;
use Adiq\LiberoBundle\Entity\Book;
use Adiq\LiberoBundle\Entity\Reader;
use Adiq\LiberoBundle\Form\RentBookType;

/**
 * Heart of Libero.
 * Action controller.
 *
 * @Route("/")
 */
class ActionController extends Controller
{

    /**
     * Rent Book Action
     *
     * @Route("/rent", name="rent")
     * @Method("GET")
     * @Template("AdiqLiberoBundle:Action:rentBook.html.twig")
     */
    public function rentBookAction()
    {
        $entity = new Action();
        $form   = $this->createRentForm($entity);

        return [
            'entity' => $entity,
            'form'   => $form->createView(),
        ];
    }

    /**
     * Creates a form to rent book.
     *
     * @param Action $action entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createRentForm(Action $entity)
    {
        $form = $this->createForm(new RentBookType(), $entity, array(
            'action' => $this->generateUrl('rent_post'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Wypożycz'));

        return $form;
    }

    /**
     * Rent Book Action
     *
     * @Route("/rent", name="rent_post")
     * @Method("POST")
     * @Template("AdiqLiberoBundle:Action:rentBook.html.twig")
     */
    public function doRentBookAction(Request $request)
    {
        $entity = new Action();
        $form = $this->createRentForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $book = $entity->getBook();
            $book->setIsRented(true);
            $em->persist($book);
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Wypożyczono książkę! :)');
            return $this->redirect($this->generateUrl('splash'));
        }

        return [
            'entity' => $entity,
            'form'   => $form->createView(),
        ];
    }



    /**
     * Return Book Action
     *
     * @Route("/return", name="return")
     * @Method("GET")
     * @Template("AdiqLiberoBundle:Action:returnBook.html.twig")
     */
    public function returnBookAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('AdiqLiberoBundle:Action');

        $query = $repository->createQueryBuilder('a')
            ->where('a.inDate IS NULL')
            ->orderBy('a.outDate', 'DESC')
            ->getQuery();

        $entities = $query->getResult();

        return [
            'entities' => $entities,
        ];
    }

    /**
     * Return action
     *
     * @Route("/return/{id}", name="return_update")
     * @Method("GET")
     * @Template("AdiqLiberoBundle:Action:returnBook.html.twig")
     */
    public function doReturnBookAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdiqLiberoBundle:Action')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Action entity.');
        }

        $entity->setInDate(new \DateTime('now'));
        $book =  $entity->getBook();
        $book->setIsRented(false);
        $em->persist($book);
        $em->persist($entity);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice', 'Oddano książkę! :)');
        return $this->redirect($this->generateUrl('splash'));
    }


    /**
     * Report Page One
     *
     * @Route("/report/books", name="report_books")
     * @Method("GET")
     * @Template("AdiqLiberoBundle:Action:reportBooks.html.twig")
     */
    public function reportBooksAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('AdiqLiberoBundle:Action');

        $query = $repository->createQueryBuilder('a')
            ->where('a.inDate IS NULL')
            ->orderBy('a.outDate', 'DESC')
            ->getQuery();

        $entities = $query->getResult();

        return [
            'entities' => $entities
        ];
    }

    /**
     * Report Page Two
     *
     * @Route("/report/readers", name="report_readers")
     * @Method("GET")
     * @Template("AdiqLiberoBundle:Action:reportReaders.html.twig")
     */
    public function reportReadersAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('AdiqLiberoBundle:Action');

        $query = $repository->createQueryBuilder('a')
            ->getQuery();

        $repository2 = $this->getDoctrine()
            ->getRepository('AdiqLiberoBundle:Reader');

        $query2 = $repository2->createQueryBuilder('a')
            ->getQuery();

        $raw_users = $query2->getResult();
        $actions = $query->getResult();

        foreach ($raw_users as $u) {
            $user[$u->getId()]['name'] = $u->getName();
            $user[$u->getId()]['lastname'] = $u->getLastname();
        }

        foreach($user as $k => $v) {
            $out[$k]['name'] = $v['name'];
            $out[$k]['lastname'] = $v['lastname'];
            $out[$k]['books'] = 0;
            $out[$k]['time'] = 0;
            $out[$k]['xtime'] = 0;

            foreach($actions as $a) {
                $reader = $a->getReader();
                if($reader->getId() == $k) {
                    $out[$k]['books'] += 1;
                    $outDate = $a->getOutDate();
                    $inDate = $a->getInDate();
                    if($inDate != null) {
                        $datediff = $outDate->diff($inDate);
                        $out[$k]['time'] += $datediff->days;
                        $out[$k]['xtime'] += 1;
                    }
                }
            }

            if($out[$k]['xtime']>0) { $out[$k]['time'] = $out[$k]['time']/$out[$k]['xtime']; }
            unset($out[$k]['xtime']);
        }

        return [
            'out' => $out,
        ];
    }

}
