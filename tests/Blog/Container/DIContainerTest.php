<?php

namespace Tgu\Laperdina\PhpUnit\Blog\Container;

use PHPUnit\Framework\TestCase;
use Tgu\Laperdina\Blog\Container\DIContainer;
use Tgu\Laperdina\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use Tgu\Laperdina\Blog\Repositories\UserRepository\InMemoryUserRepository;
use Tgu\Laperdina\Blog\User;
use Tgu\Laperdina\Exceptions\NotFoundException;

class DIContainerTest extends TestCase {
    public function testItThrowAnExceptionResolveType(): void {
        $container = new DIContainer();
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Cannot resolve type User');
        $container->get(User::class);
    }

    public function testItResolvesClassWithoutDependencies(): void {
        $container = new DIContainer();
        $object = $container->get(SomeClassWithoutDependencies::class);
        $this->assertInstanceOf(SomeClassWithoutDependencies::class, $object);
    }

    public function testItResolvesClassByContract(): void {
        $container = new DIContainer();
        $container->bind(UsersRepositoryInterface::class, InMemoryUserRepository::class);
        $object = $container->get(UsersRepositoryInterface::class);
        $this->assertInstanceOf(InMemoryUserRepository::class, $object);
    }

    public function testItReturnsPredefinedObject(): void {
        $container = new DIContainer();
        $container->bind(SomeClassWithParameter::class, new SomeClassWithParameter(43));
        $object = $container->get(SomeClassWithParameter::class);
        $this->assertInstanceOf(SomeClassWithParameter::class, $object);
        $this->assertSame(43, $object->geyValue());
    }

    public function testItResolvesClassWithDepending(): void {
        $container = new DIContainer();
        $container->bind(SomeClassWithParameter::class, new SomeClassWithParameter(43));
        $object = $container->get(ComeClassDependingOnAnother::class);
        $this->assertInstanceOf(ComeClassDependingOnAnother::class, $object);
    }
}