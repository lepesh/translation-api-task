<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Translation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Translation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Translation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Translation[]    findAll()
 * @method Translation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Translation::class);
    }

    public function save(Translation $translation): Translation
    {
        $this->_em->persist($translation);
        $this->_em->flush();

        return $translation;
    }

    public function delete(Translation $translation): Translation
    {
        $this->_em->remove($translation);
        $this->_em->flush();

        return $translation;
    }
}
