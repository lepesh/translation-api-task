<?php

namespace App\Entity;

use App\Helper\TokenHelper;
use App\Repository\ApiTokenRepository;
use App\Traits\IdentityTrait;
use App\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApiTokenRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class ApiToken
{
    use IdentityTrait, TimestampableTrait;

    public const ROLE_READ = 'ROLE_READ';
    public const ROLE_WRITE = 'ROLE_WRITE';

    /**
     * @ORM\Column(type="string", unique=true, length=32)
     */
    private string $token;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles;

    public function __construct()
    {
        $this->token = TokenHelper::generateToken();
        $this->roles = [self::ROLE_READ];
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return ApiToken
     */
    public function setToken(string $token): ApiToken
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     * @return ApiToken
     */
    public function setRoles(array $roles): ApiToken
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @param string $role
     * @return ApiToken
     */
    public function addRole(string $role): ApiToken
    {
        $this->roles[] = $role;
        return $this;
    }
}