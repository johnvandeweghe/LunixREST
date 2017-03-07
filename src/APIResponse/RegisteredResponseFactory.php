<?php
namespace LunixREST\APIResponse;

use LunixREST\APIResponse\Exceptions\NotAcceptableResponseTypeException;

/**
 * A ResponseFactory implementation that allows the case-insensitive registration of APIResponseDataSerializers to a MIME type.
 * It then uses the registered APIResponseDataSerializers to serialize APIResponses while building them from APIResponseData.
 * This provides a good example on how to actually convert APIResponseData to a SteamInterface.
 * Class RegisteredResponseFactory
 * @package LunixRESTBasics\APIResponse
 */
class RegisteredResponseFactory implements ResponseFactory
{
    /**
     * @var APIResponseDataSerializer[]
     */
    protected $serializers = [];

    /**
     * RegisteredResponseFactory constructor.
     * @param APIResponseDataSerializer[] $responseTypes
     */
    public function __construct($responseTypes = [])
    {
        foreach($responseTypes as $mimeType => $serializer) {
            $this->registerSerializer($mimeType, $serializer);
        }
    }

    /**
     * @param $mimeType
     * @param APIResponseDataSerializer $dataSerializer
     */
    public function registerSerializer($mimeType, APIResponseDataSerializer $dataSerializer)
    {
        $this->serializers[strtolower($mimeType)] = $dataSerializer;
    }

    /**
     * @param APIResponseData $data
     * @param array $acceptedMIMETypes
     * @return APIResponse
     * @throws NotAcceptableResponseTypeException
     */
    public function getResponse(APIResponseData $data, array $acceptedMIMETypes): APIResponse
    {
        if (empty($acceptedMIMETypes)) {
            $acceptedMIMETypes = $this->getSupportedMIMETypes();
        }

        foreach ($acceptedMIMETypes as $acceptedMIMEType) {
            if(isset($this->serializers[strtolower($acceptedMIMEType)])) {
                return new APIResponse($acceptedMIMEType, $this->serializers[strtolower($acceptedMIMEType)]->serialize($data));
            }
        }

        throw new NotAcceptableResponseTypeException("None of the acceptable types are supported");
    }

    /**
     * @return string[]
     */
    public function getSupportedMIMETypes(): array
    {
        return array_keys($this->serializers);
    }
}
