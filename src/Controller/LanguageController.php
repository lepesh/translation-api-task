<?php
declare(strict_types=1);

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
    public function list(LanguageRepository $languageRepository): Response
    {
        $languages = $languageRepository->findAll();
        $view = $this->view($languages);

        return $this->handleView($view);
    }
}
