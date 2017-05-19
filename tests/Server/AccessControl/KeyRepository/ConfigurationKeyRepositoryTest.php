<?php
namespace LunixREST\Server\AccessControl\KeyRepository;

class ConfigurationKeyRepositoryTest extends ArrayKeyRepositoryTest
{
    protected function getKeyRepository($keys)
    {
        $mockedConfiguration = $this->getMockBuilder('\LunixREST\Configuration\Configuration')->getMock();
        $mockedConfiguration->method('get')->willReturn($keys);
        $mockedConfiguration->method('has')->willReturn(true);
        return new ConfigurationKeyRepository($mockedConfiguration, '', '');
    }
}
