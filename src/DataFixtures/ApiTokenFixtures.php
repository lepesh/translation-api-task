<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\ApiToken;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ApiTokenFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $apiTokenReadOnly = new ApiToken();
        $apiTokenReadWrite = (new ApiToken())->addRole(ApiToken::ROLE_WRITE);
        $manager->persist($apiTokenReadOnly);
        $manager->persist($apiTokenReadWrite);
        $manager->flush();
    }
}
