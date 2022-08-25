<?php
final class Url
{
    private array $parts;
    private string $url;
    public function __construct(string $url)
    {
        $this->url = $url;
        $matches = [];
        preg_match('~^(https?)://([^/]*)([^?]*)?\??([^#]*)?#(.*)?$~', $this->url, $matches);
        array_shift($matches);
        $this->parts = array_values($matches);
    }
    public function getScheme(): string
    {
        return $this->parts[0];
    }
    public function getHost(): string
    {
        return $this->parts[1];
    }
    public function getPath(): string
    {
        return $this->parts[2];
    }
}