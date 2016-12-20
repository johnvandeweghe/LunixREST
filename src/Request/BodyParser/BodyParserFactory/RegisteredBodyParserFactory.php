<?php
namespace LunixREST\Request\BodyParser\BodyParserFactory;

use LunixREST\Request\BodyParser\BodyParser;
use LunixREST\Request\BodyParser\BodyParserFactory\Exceptions\UnknownContentTypeException;

/**
 * A BodyParserFactory that is configured post construction with body parser/content type mappings
 * Class RegisteredBodyParserFactory
 * @package LunixREST\Request\BodyParser
 */
class RegisteredBodyParserFactory implements BodyParserFactory
{

    protected $contentTypeToParserMap;

    /**
     * RegisteredBodyParserFactory constructor.
     * @param BodyParser[] $mappings keyed by content type
     */
    public function __construct($mappings = [])
    {
        foreach ($mappings as $contentType => $bodyParser) {
            $this->add($contentType, $bodyParser);
        }
    }

    /**
     * @param $contentType
     * @param BodyParser $bodyParser
     */
    public function add($contentType, BodyParser $bodyParser)
    {
        $this->contentTypeToParserMap[strtolower($contentType)] = $bodyParser;
    }

    /**
     * Parses API request data out of a url
     * @param string $contentType
     * @return BodyParser
     * @throws UnknownContentTypeException
     */
    public function create(string $contentType): BodyParser
    {
        if (isset($this->contentTypeToParserMap[strtolower($contentType)])) {
            return $this->contentTypeToParserMap[strtolower($contentType)];
        }

        throw new UnknownContentTypeException("Unknown content type: $contentType");
    }
}
