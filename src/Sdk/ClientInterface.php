<?php

namespace FourLi\Tools\Sdk;

interface ClientInterface
{
    /** @return bool @throws \Exception */
    public function check();

    /** @return string */
    public function getRoute();

    /** @return string */
    public function getMethod();

    /** @return array|object */
    public function getApiParameters();
}
