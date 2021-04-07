<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Language;
use App\Entity\Translation;
use App\Form\Type\MachineTranslateType;
use App\Form\Type\TranslationType;
use App\Manager\TranslationManager;
use App\Response\ZipFileResponse;
use App\Service\MachineTranslator;
use App\Helper\Zipper\TranslationJsonZipper;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/translations")
 */
class TranslationController extends AbstractFOSRestController
{
    private TranslationManager $translationManager;

    public function __construct(TranslationManager $repository)
    {
        $this->translationManager = $repository;
    }

    /**
     * @Route("/export", methods={"GET"})
     */
    public function export(Request $request): Response
    {
        $format = $request->get('format', TranslationJsonZipper::JSON_EXTENSION);
        $content = $this->translationManager->zip($format);
        $filename = $this->translationManager->generateZipFilename();

        return new ZipFileResponse($content, $filename);
    }

    /**
     * @Route("", methods={"GET"})
     */
    public function list(): Response
    {
        $translations = $this->translationManager->getAll();
        $view = $this->view($translations);

        return $this->handleView($view);
    }

    /**
     * @Route("", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $translation = new Translation();
        $form = $this->createForm(TranslationType::class, $translation);
        $form->submit($request->toArray());
        if (!$form->isValid()) {
            return $this->handleView($this->view($form));
        }
        $this->translationManager->save($translation);

        return $this->handleView($this->view($translation));
    }

    /**
     * @Route("/{id}", methods={"GET"})
     */
    public function retrieve(Translation $translation): Response
    {
        $view = $this->view($translation);

        return $this->handleView($view);
    }

    /**
     * @Route("/{id}", methods={"PUT"})
     */
    public function update(Request $request, Translation $translation): Response
    {
        $form = $this->createForm(TranslationType::class, $translation);
        $form->submit($request->toArray());
        if (!$form->isValid()) {
            return $this->handleView($this->view($form));
        }
        $this->translationManager->save($translation);

        return $this->handleView($this->view($translation));
    }

    /**
     * @Route("/{id}", methods={"DELETE"})
     */
    public function delete(Translation $translation): Response
    {
        $this->translationManager->delete($translation);

        return new Response();
    }

    /**
     * @Route("/{id}/machine-translate", methods={"POST"})
     */
    public function machineTranslate(
        Request $request,
        Translation $translation,
        MachineTranslator $machineTranslator
    ): Response
    {
        $form = $this->createForm(MachineTranslateType::class);
        $form->submit($request->toArray());
        if (!$form->isValid()) {
            return $this->handleView($this->view($form));
        }
        /** @var Language $language */
        $language = $form->getData()['language'];
        $newTranslation = $machineTranslator->translate($translation, $language);
        $this->translationManager->save($newTranslation);

        return $this->handleView($this->view($newTranslation));
    }
}
