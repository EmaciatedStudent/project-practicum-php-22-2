<?php

namespace Tgu\Laperdina\Blog\Http\Auth;

use DateTimeImmutable;
use Tgu\Laperdina\Blog\Http\Request;
use Tgu\Laperdina\Blog\Post;
use Tgu\Laperdina\Blog\Repositories\AuthTokenRepository\AuthTokenRepositoryInterface;
use Tgu\Laperdina\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use Tgu\Laperdina\Blog\User;
use Tgu\Laperdina\Exceptions\AuthException;
use Tgu\Laperdina\Exceptions\AuthTokensRepositoryException;
use Tgu\Laperdina\Exceptions\HttpException;

class BearerTokenAuthentication implements TokenAuthenticationInterface {
    private  const HEADER_PREFIX = 'Bearer';
    private AuthTokenRepositoryInterface $authTokenRepository;
    private UsersRepositoryInterface $usersRepository;

    public function __construct($authTokenRepository, $usersRepository) {
        $this->authTokenRepository = $authTokenRepository;
        $this->usersRepository = $usersRepository;
    }

    public function user(Request $request): User {
        try {
            $header = $request->header('Authorization');
        }
        catch (HttpException $exception) {
            throw new AuthException($exception->getMessage());
        }

        if(!str_starts_with($header, self::HEADER_PREFIX)) {
            throw new AuthException("Malformed token:[$header]");
        }

        $token = mb_substr($header, strlen(self::HEADER_PREFIX));
        try {
            $authToken = $this->authTokenRepository->get($token);
        }
        catch (AuthTokensRepositoryException $exception) {
            throw new AuthException("Bad token:[$token]");
        }

        if(!$authToken->getExpiresOn()<= new DateTimeImmutable()) {
            throw new AuthException("Token expired:[$token]");
        }

        $userUUid = $authToken->getUseruuid();
        return $this->usersRepository->getByUuid($userUUid);
    }

    public function post(Request $request): Post {

    }
}