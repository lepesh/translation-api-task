<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\TranslationKey;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TranslationKeyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $keys = ['welcome', 'contacts', 'subscribe', 'team', 'careers', 'news', 'signin', 'signup', 'logout'];
        foreach ($keys as $key) {
            $translationKey = new TranslationKey();
            $translationKey->setName('index.' . $key);
            $manager->persist($translationKey);
        }

        $manager->flush();
    }
}
