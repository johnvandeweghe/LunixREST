<?php
namespace LunixREST\Configuration;

class DatabaseINIConfiguration extends INIConfiguration {

    protected function getFilePath()
    {
        return "config/database.ini";
    }
}