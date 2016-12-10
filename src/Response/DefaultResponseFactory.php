<?php
namespace LunixREST\Response;

use LunixREST\Response\Exceptions\UnknownResponseTypeException;

class DefaultResponseFactory implements ResponseFactory {
    /**
     * @param ResponseData $data
     * @param string $type
     * @return Response
     * @throws UnknownResponseTypeException
     */
    public function getResponse(ResponseData $data, string $type): Response {
        switch(strtolower($type)) {
            case "json":
                return new JSONResponse($data);
            default:
                throw new UnknownResponseTypeException("Unknown response type: $type");
        }
    }

    /**
     * @return string[]
     * @throws UnknownResponseTypeException
     */
    public function getSupportedTypes(): array {
        return [
            "json"
        ];
    }
}
