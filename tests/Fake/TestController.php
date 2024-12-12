<?php
declare(strict_types = 1);
namespace mrsatik\ConsoleTest\Fake;

class TestController
{
    public function actionAdd(array $param): string
    {
        return 'success';
    }
}