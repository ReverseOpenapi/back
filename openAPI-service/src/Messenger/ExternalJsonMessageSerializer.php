<?php

namespace App\Messenger;
use App\Messenger\Message\CreateOpenApiDocument;
use Exception;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class ExternalJsonMessageSerializer implements SerializerInterface
{
    public function decode(array $encodedEnvelope): Envelope
    {
        $body = $encodedEnvelope['body'];
        $data = json_decode($body, true);
        $message = new CreateOpenApiDocument($data['documentId']);

        return new Envelope($message);
    }

    /**
     * @throws Exception
     */
    public function encode(Envelope $envelope): array
    {
        $message = $envelope->getMessage();

        if ($message instanceof CreateOpenApiDocument) {
            $data = ['documentId' => $message->getDocumentId()];
        } else {
            throw new Exception('Unsupported message class');
        }

        return [
            'body' => json_encode($data),
        ];
    }
}