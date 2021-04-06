<?php
declare(strict_types=1);

namespace App\Manager;

use App\Entity\Language;
use App\Repository\LanguageRepository;

class LanguageManager
{
    private LanguageRepository $repository;

    public function __construct(LanguageRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Language[]
     */
    public function getAll(): array
    {
        return $this->repository->findAll();
    }
}
