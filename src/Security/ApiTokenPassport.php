<?php
declare(strict_types=1);

namespace App\Security;

use App\Entity\ApiToken;
use LogicException;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportTrait;

class ApiTokenPassport implements PassportInterface
{
    use PassportTrait;

    protected ?ApiToken $apiToken = null;

    public function __construct(ApiTokenBadge $apiTokenBadge)
    {
        $this->addBadge($apiTokenBadge);
    }

    public function getApiToken(): ApiToken
    {
        if (null === $this->apiToken) {
            if (!$this->hasBadge(ApiTokenBadge::class)) {
                throw new LogicException('ApiTokenBadge is not configured for this passport.');
            }
            $this->apiToken = $this->getBadge(ApiTokenBadge::class)->getApiToken();
        }

        return $this->apiToken;
    }
}
