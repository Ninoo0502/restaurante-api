<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Psr\Log\LoggerInterface;

class ApiKeyAuthenticator extends AbstractAuthenticator
{
    private string $apiKey;
    private LoggerInterface $logger;

    public function __construct(string $apiKey, LoggerInterface $logger)
    {
        $this->apiKey = $apiKey;
        $this->logger = $logger;
    }

    public function supports(Request $request): ?bool
    {
        $hasHeader = $request->headers->has('X-Auth-Token');
        $this->logger->info('[supports] X-Auth-Token present: ' . ($hasHeader ? 'yes' : 'no'));
        return $hasHeader;
    }

    public function authenticate(Request $request): SelfValidatingPassport
    {
        $receivedToken = $request->headers->get('X-Auth-Token');

        // Logging para diagnóstico
        $this->logger->info('[authenticate] Received token: ' . $receivedToken);
        $this->logger->info('[authenticate] Expected token: ' . $this->apiKey);

        if ($receivedToken !== $this->apiKey) {
            $this->logger->warning('[authenticate] Invalid API Key');
            throw new AuthenticationException('Invalid API Key');
        }

        $this->logger->info('[authenticate] API Key valid');
        return new SelfValidatingPassport(new UserBadge('api-user'));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $this->logger->info('[success] Authenticated successfully');
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $this->logger->error('[failure] Authentication failed: ' . $exception->getMessage());

        return new JsonResponse(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
    }
}
