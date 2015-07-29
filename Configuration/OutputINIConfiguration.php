<?php
namespace LunixREST\Configuration;

class OutputINIConfiguration extends INIConfiguration {

    protected function getFilePath()
    {
        return "config/output.ini";
    }
}
