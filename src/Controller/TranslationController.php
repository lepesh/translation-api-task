<?php

namespace App\Controller;

use App\Entity\Language;
use App\Entity\Translation;
use App\Form\Type\MachineTranslateType;
use App\Form\Type\TranslationType;
use App\Repository\TranslationRepository;
use App\Service\Translation\MachineTranslator;
use App\Helper\Zipper\TranslationJsonZipper;
use App\Helper\Zipper\TranslationYamlZipper;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
     * @Route("/export", methods={"GET"})
     */
    public function exportAction(Request $request): Response
    {
        $format = $request->get('format', TranslationJsonZipper::JSON_EXTENSION);
        $translationZipper = match ($format) {
            TranslationJsonZipper::JSON_EXTENSION => new TranslationJsonZipper($this->repository),
            TranslationYamlZipper::YAML_EXTENSION => new TranslationYamlZipper($this->repository),
            default => throw new BadRequestHttpException('Unsupported format'),
        };
        $zipped = $translationZipper->zip();

        $filename = sprintf('translations-%s-%s.zip', $format, date('YmdHis'));
        $response = new Response();
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', 'application/zip');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '";');
        $response->setContent($zipped);

        return $response;
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

    /**
     * @Route("/{id}/machine-translate", methods={"POST"})
     */
    public function machineTranslateAction(
        Request $request,
        Translation $translation,
        MachineTranslator $machineTranslator,
        ValidatorInterface $validator
    ): Response
    {
        $form = $this->createForm(MachineTranslateType::class);
        $form->submit($request->toArray());
        if (!$form->isValid()) {
            return $this->handleView($this->view($form));
        }
        /** @var Language $language */
        $language = $form->getData()['language'];
        $translatedText = $machineTranslator->translate($translation->getValue(), $language->getIsoCode());
        $newTranslation = new Translation($translation->getTranslationKey(), $language);
        $newTranslation->setValue($translatedText);
        // validate if key-language pair is unique
        $violations = $validator->validate($newTranslation);
        if ($violations->count() > 0) {
            return $this->handleView($this->view($violations, Response::HTTP_UNPROCESSABLE_ENTITY));
        }
        $this->repository->save($newTranslation);

        return $this->handleView($this->view($newTranslation));
    }
}
