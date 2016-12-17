<?php
namespace LunixREST\Response;

use LunixREST\Response\Exceptions\NotAcceptableResponseTypeException;

/**
 * Class DefaultResponseFactory
 * @package LunixREST\Response
 */
class DefaultResponseFactory implements ResponseFactory {
    /**
     * @param ResponseData $data
     * @param array $acceptedMIMETypes
     * @return Response
     * @throws NotAcceptableResponseTypeException
     */
    public function getResponse(ResponseData $data, array $acceptedMIMETypes): Response {
        if(empty($acceptedMIMETypes)){
            $acceptedMIMETypes = $this->getSupportedMIMETypes();
        }

        foreach($acceptedMIMETypes as $acceptedMIMEType) {
            switch (strtolower($acceptedMIMEType)) {
                case "application/json":
                    return new JSONResponse($data);
            }
        }

        throw new NotAcceptableResponseTypeException("None of the accepted types are supported");
    }

    /**
     * @return string[]
     */
    public function getSupportedMIMETypes(): array {
        return [
            "application/json"
        ];
    }
}
