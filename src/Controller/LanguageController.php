<?php

namespace App\Controller;

use App\Repository\LanguageRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/languages")
 */
class LanguageController extends AbstractFOSRestController
{
    /**
     * @Route("/", methods={"GET"})
     */
    public function listAction(LanguageRepository $languageRepository): Response
    {
        $languages = $languageRepository->findAll();
        $view = $this->view($languages, 200);

        return $this->handleView($view);
    }
}
