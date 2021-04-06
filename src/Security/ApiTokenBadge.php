<?php
declare(strict_types=1);

namespace App\Security;

use App\Entity\ApiToken;
use App\Repository\ApiTokenRepository;
use Symfony\Component\Security\Core\Exception\TokenNotFoundException;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\BadgeInterface;

class ApiTokenBadge implements BadgeInterface
{
    private string $tokenString;
    private ApiTokenRepository $apiTokenRepository;


    public function __construct(string $tokenString, ApiTokenRepository $apiTokenRepository)
    {
        $this->tokenString = $tokenString;
        $this->apiTokenRepository = $apiTokenRepository;
    }

    public function getApiToken(): ApiToken
    {
        $apiToken = $this->apiTokenRepository->findOneBy(['token' => $this->tokenString]);
        if (!$apiToken) {
            throw new TokenNotFoundException();
        }

        return $apiToken;
    }

    public function isResolved(): bool
    {
        return true;
    }
}
