<?php
declare(strict_types=1);

namespace App\Manager;

use App\Entity\Translation;
use App\Helper\Zipper\TranslationJsonZipper;
use App\Helper\Zipper\TranslationYamlZipper;
use App\Repository\TranslationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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

    public function zip(string $format): string
    {
        $translations = $this->repository->findAll();
        $translationZipper = match ($format) {
            TranslationJsonZipper::JSON_EXTENSION => new TranslationJsonZipper($translations),
            TranslationYamlZipper::YAML_EXTENSION => new TranslationYamlZipper($translations),
            default => throw new BadRequestHttpException('Unsupported format'),
        };

        return $translationZipper->zip();
    }

    public function generateZipFilename(): string
    {
        return sprintf('translations-%s.zip', date('YmdHis'));
    }
}
