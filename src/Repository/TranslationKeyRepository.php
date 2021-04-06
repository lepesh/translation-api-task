<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\TranslationKey;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TranslationKey|null find($id, $lockMode = null, $lockVersion = null)
 * @method TranslationKey|null findOneBy(array $criteria, array $orderBy = null)
 * @method TranslationKey[]    findAll()
 * @method TranslationKey[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TranslationKeyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TranslationKey::class);
    }

    public function save(TranslationKey $translationKey): TranslationKey
    {
        $this->_em->persist($translationKey);
        $this->_em->flush();

        return $translationKey;
    }

    public function delete(TranslationKey $translationKey): TranslationKey
    {
        $this->_em->remove($translationKey);
        $this->_em->flush();

        return $translationKey;
    }
}
