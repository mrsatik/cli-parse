<?php
declare(strict_types = 1);
namespace mrsatik\Console;

use mrsatik\Console\Exception\RouteException;

class Request implements RequestInterface
{

    /**
     * input parametrs
     *
     * @var array
     */
    private $_params;

    /**
     * Parse cli command and build name of route, action and params
     *
     * @throws RouteException
     * @return [string,
     *         string,
     *         array[]]
     */
    public function resolve(): array
    {
        if (isset($this->getParams()[0]) === false) {
            throw new RouteException('Can not find route');
        }

        $params = [];

        if (strpos($this->_params[0], ':') !== false) {
            list ($route, $action) = explode(':', $this->_params[0]);
            $params = array_slice($this->_params, 1);
        } else {
            $route = $this->_params[0];
            $action = $this->_params[1] ?? 'default';
            $params = array_slice($this->_params, 2);
        }

        return [
            $route,
            $action,
            $params
        ];
    }

    /**
     * Returns the command line arguments.
     *
     * @return array the command line arguments. It does not include the entry script name.
     */
    private function getParams(): array
    {
        if ($this->_params === null) {
            if (isset($_SERVER['argv'])) {
                $this->_params = $_SERVER['argv'];
                array_shift($this->_params);
            } else {
                $this->_params = [];
            }
        }

        return $this->_params;
    }
}
