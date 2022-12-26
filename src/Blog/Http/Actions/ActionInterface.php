<?php

namespace Tgu\Laperdina\Blog\Http\Actions;

use Tgu\Laperdina\Blog\Http\Request;
use Tgu\Laperdina\Blog\Http\Response;

interface ActionInterface {
    public function handle(Request $request):Response;
}