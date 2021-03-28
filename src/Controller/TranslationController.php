<?php

namespace App\Controller;

use App\Entity\Translation;
use App\Form\Type\TranslationType;
use App\Repository\TranslationRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/translations")
 */
class TranslationController extends AbstractFOSRestController
{
    private TranslationRepository $repository;
    
    public function __construct(TranslationRepository $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * @Route("", methods={"GET"})
     */
    public function listAction(): Response
    {
        $translations = $this->repository->findAll();
        $view = $this->view($translations);

        return $this->handleView($view);
    }

    /**
     * @Route("", methods={"POST"})
     */
    public function createAction(Request $request): Response
    {
        $translation = new Translation();
        $form = $this->createForm(TranslationType::class, $translation);
        $form->submit($request->toArray());
        if (!$form->isValid()) {
            return $this->handleView($this->view($form));
        }
        $this->repository->save($translation);

        return $this->handleView($this->view($translation));
    }

    /**
     * @Route("/{id}", methods={"GET"})
     */
    public function getAction(Translation $translation): Response
    {
        $view = $this->view($translation);

        return $this->handleView($view);
    }

    /**
     * @Route("/{id}", methods={"PUT"})
     */
    public function updateAction(Request $request, Translation $translation): Response
    {
        $form = $this->createForm(TranslationType::class, $translation);
        $form->submit($request->toArray());
        if (!$form->isValid()) {
            return $this->handleView($this->view($form));
        }
        $this->repository->save($translation);

        return $this->handleView($this->view($translation));
    }

    /**
     * @Route("/{id}", methods={"DELETE"})
     */
    public function deleteAction(Translation $translation): Response
    {
        $this->repository->delete($translation);

        return new Response();
    }
}
