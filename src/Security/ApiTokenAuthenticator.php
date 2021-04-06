<?php
declare(strict_types=1);

namespace App\Security;

use App\Repository\ApiTokenRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\LogicException;
use Symfony\Component\Security\Http\Authenticator\AuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;

class ApiTokenAuthenticator implements AuthenticatorInterface
{
    private ApiTokenRepository $apiTokenRepository;

    public function __construct(ApiTokenRepository $apiTokenRepository)
    {
        $this->apiTokenRepository = $apiTokenRepository;
    }

    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning `false` will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request): ?bool
    {
        return $request->headers->has('X-API-TOKEN');
    }

    public function authenticate(Request $request): PassportInterface
    {
        $apiToken = $request->headers->get('X-API-TOKEN');
        if (null === $apiToken) {
            // The token header was empty, authentication fails with HTTP Status
            // Code 401 "Unauthorized"
            throw new CustomUserMessageAuthenticationException('No API token provided');
        }

        return new ApiTokenPassport(new ApiTokenBadge($apiToken, $this->apiTokenRepository));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // on success, let the request continue
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function createAuthenticatedToken(PassportInterface $passport, string $firewallName): TokenInterface
    {
        if (!$passport instanceof ApiTokenPassport) {
            throw new LogicException(sprintf('Passport does not contain an ApiToken.'));
        }

        return new AuthenticatedToken($passport->getApiToken(), $passport->getApiToken()->getRoles());
    }
}