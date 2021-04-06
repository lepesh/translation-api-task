<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\TranslationKey;
use App\Form\Type\TranslationKeyType;
use App\Manager\TranslationKeyManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/translation-keys")
 */
class TranslationKeyController extends AbstractFOSRestController
{
    private TranslationKeyManager $translationKeyManager;
    
    public function __construct(TranslationKeyManager $translationKeyManager)
    {
        $this->translationKeyManager = $translationKeyManager;
    }
    
    /**
     * @Route("", methods={"GET"})
     */
    public function list(): Response
    {
        $keys = $this->translationKeyManager->getAll();
        $view = $this->view($keys);

        return $this->handleView($view);
    }

    /**
     * @Route("", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $key = new TranslationKey();
        $form = $this->createForm(TranslationKeyType::class, $key);
        $form->submit($request->toArray());
        if (!$form->isValid()) {
            return $this->handleView($this->view($form));
        }
        $this->translationKeyManager->save($key);

        return $this->handleView($this->view($key));
    }

    /**
     * @Route("/{id}", methods={"GET"})
     */
    public function retrieve(TranslationKey $key): Response
    {
        $view = $this->view($key);

        return $this->handleView($view);
    }

    /**
     * @Route("/{id}", methods={"PUT"})
     */
    public function update(Request $request, TranslationKey $key): Response
    {
        $form = $this->createForm(TranslationKeyType::class, $key);
        $form->submit($request->toArray());
        if (!$form->isValid()) {
            return $this->handleView($this->view($form));
        }
        $this->translationKeyManager->save($key);

        return $this->handleView($this->view($key));
    }

    /**
     * @Route("/{id}", methods={"DELETE"})
     */
    public function delete(TranslationKey $key): Response
    {
        $this->translationKeyManager->delete($key);

        return new Response();
    }
}
