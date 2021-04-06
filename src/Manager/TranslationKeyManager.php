<?php
declare(strict_types=1);

namespace App\Manager;

use App\Entity\TranslationKey;
use App\Repository\TranslationKeyRepository;
use Doctrine\ORM\EntityManagerInterface;

class TranslationKeyManager
{
    private EntityManagerInterface $em;

    private TranslationKeyRepository $repository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(TranslationKey::class);
    }

    /**
     * @return TranslationKey[]
     */
    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function save(TranslationKey $translationKey): TranslationKey
    {
        $this->em->persist($translationKey);
        $this->em->flush();

        return $translationKey;
    }

    public function delete(TranslationKey $translationKey): TranslationKey
    {
        $this->em->remove($translationKey);
        $this->em->flush();

        return $translationKey;
    }
}
