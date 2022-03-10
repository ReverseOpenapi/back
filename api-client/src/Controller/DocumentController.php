<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse, Response, Request};
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Utils\Validator;
use App\Repository\OpenApiDocumentRepository;
use Ramsey\Uuid\Uuid;
use App\Model\DocumentPayload;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Route\Document\Create;
use Gaufrette\Filesystem;
use Symfony\Component\HttpFoundation\HeaderUtils;
use App\Messenger\Message\CreateOpenApiDocument;
use Symfony\Component\Messenger\MessageBusInterface;


#[Route('/api/document')]
#[OA\Tag(name: "Document")]
class DocumentController extends AbstractController
{
    /**
     * Create an Open Api Document
     *
     * @param  Request $request
     * @param  ManagerRegistry $doctrine
     * @param  Validator $validator
     * @return JsonResponse
     */
    #[OA\Parameter(
        name: 'body',
        in: 'path',
        required: true,
        schema: new OA\Schema(
            new Model(
                type: DocumentPayload::class,
                groups: ['payload']
            )
        )
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            examples: [
                new OA\Examples(
                    example: 'create_ok',
                    summary :'Exemple 1',
                    value: '{
                        "title": "Pet Store",
                        "description": "This is a Pet Store",
                        "version": "3.0.0",
                        "paths": [
                            {
                                "endpoint": "/pet/{id}",
                                "pathItems": [
                                    {
                                        "httpMethod": "PUT",
                                        "summary": "Update a pet",
                                        "description": "Pet object that needs to be added to the store",
                                        "tags": [
                                            "pet"
                                        ],
                                        "responses": [
                                            {
                                                "httpStatusCode": 405,
                                                "description": "Invalid input"
                                            }
                                        ],
                                        "requestBody": {
                                            "description": "Pet object that needs to be added to the store",
                                            "required": true,
                                            "content": {
                                                "id": {
                                                    "example": 0
                                                },
                                                "name": {
                                                    "example": "doggie",
                                                    "type": "string"
                                                },
                                                "status": {
                                                    "example": "available"
                                                }
                                            }
                                        },
                                        "parameters": [
                                            {
                                                "name": "id",
                                                "required": true,
                                                "description": "ID of pet to return",
                                                "location": "query",
                                                "parameterSchema": {
                                                    "type": "integer"
                                                }
                                            }
                                        ]
                                    },
                                    {
                                        "httpMethod": "GET",
                                        "summary": "Find pet by id",
                                        "description": "Find a pet in the Pet Store",
                                        "tags": [
                                            "pet"
                                        ],
                                        "responses": [
                                            {
                                                "httpStatusCode": 200,
                                                "description": "Successful operation",
                                                "content": {
                                                    "application/json": {
                                                        "schema": {
                                                            "type": "object",
                                                            "properties": {
                                                                "id": {
                                                                    "example": 0
                                                                },
                                                                "name": {
                                                                    "example": "doggie"
                                                                },
                                                                "status": {
                                                                    "example": "available"
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        ]
                                    }
                                ]
                            }
                        ],
                        "tags": [
                            {
                                "name": "pet",
                                "description": "Everything about your Pets"
                            }
                        ]
                    }'
                )
            ]
        )
     )]
    #[OA\Response(
        response: 200,
        description: "Document has been created",
        content: new OA\JsonContent(
            examples: [
                new OA\Examples(
                    example: 'create_ok',
                    summary :'Exemple 1',
                    value: '{
                        "success": true,
                        "data": {
                            "id": "333dfadb-8867-4869-a998-8597149f97fe"
                        }
                    }'
                )
            ]
        )
     )]
    #[OA\Response(
        response: 422,
        description: "Error in Payload",
        content: new OA\JsonContent(
            examples: [
                new OA\Examples(
                    example: 'version_mission',
                    summary :'Exemple 1 - Version missing',
                    value: '{
                        "success": false,
                        "errors": {
                            "version": [
                                "This value should not be blank."
                            ]
                        }
                    }'
                ),
                new OA\Examples(
                    example: 'path_endpoint_missing',
                    summary :'Exemple 2 - Endpoint Path missing',
                    value: '{
                        "success": false,
                        "errors": {
                            "paths[0][endpoint]": [
                                "This field is missing."
                            ]
                        }
                    }'
                ),
                new OA\Examples(
                    example: 'multiple_items_missing',
                    summary :'Exemple 3 - Multiple properties missing',
                    value: '{
                        "success": false,
                        "errors": {
                            "version": [
                                "This value should not be blank."
                            ],
                            "paths[0][endpoint]": [
                                "This field is missing."
                            ],
                            "paths[0][pathItems][0][parameters][0][name]": [
                                "This field is missing."
                            ],
                            "paths[0][pathItems][0][parameters][0][required]": [
                                "This field is missing."
                            ]
                        }
                    }'
                ),
                new OA\Examples(
                    example: 'invalid_http_choice',
                    summary :'Exemple 4 - Invalid HTTP Method choice',
                    value: '{
                        "success": false,
                        "errors": {
                            "paths[0][pathItems][0][httpMethod]": [
                                "The value you selected is not a valid choice."
                            ]
                        }
                    }'
                ),
                new OA\Examples(
                    example: 'invalid_type',
                    summary :'Exemple 5 - Invalid Parameter Type',
                    value: '{
                        "success": false,
                        "errors": {
                            "version": [
                                "This value should be of type string."
                            ]
                        }
                    }'
                ),
            ]
        )
    )]
    #[Route('', name: 'document_create', methods: ['POST'])]
    public function create(Request $request, ManagerRegistry $doctrine, Validator $validator, MessageBusInterface $bus): JsonResponse
    {
        $data = json_decode($request->getContent(), true) ?? [];

        $payload = new DocumentPayload($data);

        // verify payload format
        $errors = $validator->getErrors($payload);

        if(count($errors)) {
            return new JsonResponse([
                'success' => false,
                'errors' => $errors
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // hidrate document
        $document = $payload->getDocument();

        $em = $doctrine->getManager();

        $em->persist($document);

        $em->flush();

        $bus->dispatch(new CreateOpenApiDocument($document->getId()));

        return new JsonResponse([
            'success'    => true,
            'data'      => ['id' => $document->getId()]
        ], Response::HTTP_OK);
    }


    #[Route('/download/{id}', name:'document_download', methods: ['GET'])]
    public function retrieve(FileSystem $fs, string $id) {

        if (!Uuid::isValid($id)) return new JsonResponse([ 'success' => false ], Response::HTTP_UNAUTHORIZED);

        $filename = $id . '.json';

        if (!$fs->has($filename)) return new JsonResponse([ 'success' => false ], Response::HTTP_NOT_FOUND);

        $file = $fs->get($filename);
        $response = new Response($file->getContent());

        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            $filename
        );
        
        $response->headers->set('Content-Disposition', $disposition);
        return $response;
    }

    /**
     * Retrieve an Open Api Document by it's id
     *
     * @param  string $id the id of the document
     * @param  OpenApiDocumentRepository $repo
     * @return JsonResponse
     */
    #[Route('/{id}', name: 'document_read', methods: ['GET'])]
    public function read(string $id, OpenApiDocumentRepository $repo) : JsonResponse
    {

        if (!Uuid::isValid($id)) return new JsonResponse([ 'success' => false ], Response::HTTP_UNAUTHORIZED);

        $document = $repo->find($id);

        if (!$document) return new JsonResponse([ 'success' => false ], Response::HTTP_NOT_FOUND);

        return new JsonResponse([
            'success'    => true,
            'data'      => $document->toArray()
        ], Response::HTTP_OK);
    }



}
