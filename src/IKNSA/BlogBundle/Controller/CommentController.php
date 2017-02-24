<?php

namespace IKNSA\BlogBundle\Controller;

use IKNSA\BlogBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use IKNSA\BlogBundle\Form\CommentType;

/**
 * Comment controller.
 *
 */
class CommentController extends Controller {

    /**
     * Lists all comment entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $comments = $em->getRepository('IKNSABlogBundle:Comment')->findAll();

        return $this->render('comment/index.html.twig', array(
                    'comments' => $comments,
        ));
    }

    /**
     * Creates a new comment entity.
     *
     */
    public function newAction(Request $request) {
        $comment = new Comment();
        $form = $this->createForm('IKNSA\BlogBundle\Form\CommentType', $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $comment->setUser($this->getUser());
            $em->persist($comment);
            $em->flush($comment);

            return $this->redirectToRoute('comment_show', array('id' => $comment->getId()));
        }

        return $this->render('comment/new.html.twig', array(
                    'comment' => $comment,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a comment entity.
     *
     */
    public function showAction(Comment $comment) {
        $deleteForm = $this->createDeleteForm($comment);

        return $this->render('comment/show.html.twig', array(
                    'comment' => $comment,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing comment entity.
     *
     */
    public function editAction(Request $request, Comment $comment) {
        $deleteForm = $this->createDeleteForm($comment);
        $editForm = $this->createForm('IKNSA\BlogBundle\Form\CommentType', $comment);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comment_edit', array('id' => $comment->getId()));
        }

        return $this->render('comment/edit.html.twig', array(
                    'comment' => $comment,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a comment entity.
     *
     */
    public function deleteAction(Request $request, Comment $comment) {
        $form = $this->createDeleteForm($comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush($comment);
        }

        return $this->redirectToRoute('comment_index');
    }

    /**
     * Creates a form to delete a comment entity.
     *
     * @param Comment $comment The comment entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Comment $comment) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('comment_delete', array('id' => $comment->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
