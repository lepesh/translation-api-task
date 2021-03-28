<?php

namespace App\Security;

use App\Entity\ApiToken;
use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class AuthenticatedToken extends AbstractToken
{
    protected ApiToken $apiToken;

    /**
     * @param ApiToken $apiToken
     * @param string[] $roles
     */
    public function __construct(ApiToken $apiToken, array $roles = [])
    {
        parent::__construct($roles);

        $this->apiToken = $apiToken;
        $this->setUser('anonymous');
        $this->setAuthenticated(true);
    }

    public function getApiToken(): ApiToken
    {
        return $this->apiToken;
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function __serialize(): array
    {
        return [$this->apiToken, parent::__serialize()];
    }

    /**
     * {@inheritdoc}
     */
    public function __unserialize(array $data): void
    {
        [$this->apiToken, $parentData] = $data;
        $parentData = \is_array($parentData) ? $parentData : unserialize($parentData);
        parent::__unserialize($parentData);
    }
}
