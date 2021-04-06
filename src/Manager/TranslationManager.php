<?php
declare(strict_types=1);

namespace App\Manager;

use App\Entity\Translation;
use App\Repository\TranslationRepository;
use Doctrine\ORM\EntityManagerInterface;

class TranslationManager
{
    private EntityManagerInterface $em;
    
    private TranslationRepository $repository;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(Translation::class);
    }

    /**
     * @return Translation[]
     */
    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function save(Translation $translation): Translation
    {
        $this->em->persist($translation);
        $this->em->flush();

        return $translation;
    }

    public function delete(Translation $translation): Translation
    {
        $this->em->remove($translation);
        $this->em->flush();

        return $translation;
    }
}
