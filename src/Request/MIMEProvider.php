<?php
namespace LunixREST\Request;

interface MIMEProvider {
    public function getAll(): array;
    public function getByFileExtension($extension): string;
}
