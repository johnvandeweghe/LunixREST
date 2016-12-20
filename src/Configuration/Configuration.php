<?php
namespace LunixREST\Configuration;

interface Configuration
{
    public function get($key);

    public function set($key);
}
