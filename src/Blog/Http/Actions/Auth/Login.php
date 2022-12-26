<?php

namespace Tgu\Laperdina\Blog\Http\Actions\Auth;

use Tgu\Laperdina\Blog\AuthToken;
use Tgu\Laperdina\Blog\Http\Actions\ActionInterface;
use Tgu\Laperdina\Blog\Http\Auth\PasswordAuthenticationInterface;
use Tgu\Laperdina\Blog\Http\ErrorResponse;
use Tgu\Laperdina\Blog\Http\Request;
use Tgu\Laperdina\Blog\Http\Response;
use Tgu\Laperdina\Blog\Http\SuccessResponse;
use Tgu\Laperdina\Blog\Repositories\AuthTokenRepository\AuthTokenRepositoryInterface;
use Tgu\Laperdina\Exceptions\AuthException;

class Login implements ActionInterface
{
    private PasswordAuthenticationInterface $passwordAuthentication;
    private AuthTokenRepositoryInterface $authTokenRepository;

    public function __construct($passwordAuthentication, $authTokenRepository) {
        $this->passwordAuthentication = $passwordAuthentication;
        $this->authTokenRepository = $authTokenRepository;
    }

    public function handle(Request $request): Response {
        try {
            $user = $this->passwordAuthentication->user($request);
        }
        catch (AuthException $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        $authToken = new AuthToken(
            bin2hex(random_bytes(40)),
            $user->getUuid(),
            (new \DateTimeImmutable())->modify('+1 day')
        );
        $this->authTokenRepository->save($authToken);

        return new SuccessResponse(['token' =>(string)$authToken]);
    }
}