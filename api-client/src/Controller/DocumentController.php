<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse, Response, Request};
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Utils\Validator;
use App\Repository\OpenApiDocumentRepository;
use Ramsey\Uuid\Uuid;
use App\Entity\{
    Tag,
    Path,
    PathItem,
    OpenApiDocument,
    Parameter,
    HttpResponse,
    RequestBody
};
use App\Model\DocumentPayload;

#[Route('/document')]
class DocumentController extends AbstractController
{

    #[Route('', name: 'document_create', methods: ['POST'])]
    public function create(Request $request, ManagerRegistry $doctrine, Validator $validator): Response
    {
        $data = json_decode($request->getContent(), true) ?? [];

        $payload = new DocumentPayload($data);

        $errors = $validator->getErrors($payload);

        dd('ok', $errors);





        $document = new OpenApiDocument($data);

        $errors = $validator->getErrors($document);

        if(count($errors)) {
            return new JsonResponse([
                'success' => false,
                'errors' => $errors
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $errors = [];

        if(isset($data['tags']) && count($data['tags'])){

            foreach ($data['tags'] as $key => $tag) {
                $tag = new Tag($tag);

                $tagErrors = $validator->getErrors($tag);

                if (count($tagErrors)) {
                    $errors[] = ['index' => $key, 'type' => 'tags', 'errors' => $tagErrors];
                    continue;
                }

                $document->addTag($tag);
            }
        }

        if(isset($data['paths']) && count($data['paths'])){

            foreach ($data['paths'] as $key => $path) {

                if(!(isset($path['pathItems']) && count($path['pathItems']))) continue;

                $pathEntity = new Path($path);

                $pathErrors = $validator->getErrors($pathEntity);

                if (count($pathErrors)) {
                    $errors[] = ['index' => $key, 'type' => 'paths', 'errors' => $pathErrors];
                    continue;
                }

                if (isset($path['pathItems']) && count($path['pathItems'])) {

                    foreach ($path['pathItems'] as $pathItemsKey => $pathItem) {

                        $pathItemEntity = new PathItem($pathItem);

                        $pathItemErrors = $validator->getErrors($pathItemEntity);

                        if (count($pathItemErrors)) {
                            $errors[] = ['index' => $key, 'type' => 'paths.pathItems', 'errors' => $pathItemErrors];
                            continue;
                        }

                        $document->addPath($pathEntity);

                        if (isset($pathItem['parameters'])) {

                            foreach ($pathItem['parameters'] as $key => $parameter) {
                                
                                $parameterItenty = new Parameter($parameter);
                                
                                $parameterErrors = $validator->getErrors($parameterItenty);
                                
                                if (count($parameterErrors)) {
                                    $errors[] = ['index' => $key, 'type' => 'paths.pathItems.parameters', 'errors' => $parameterErrors];
                                    continue;
                                }
                                
                                $pathItemEntity->addParameter($parameterItenty);
                            }
                        }

                        if (isset($pathItem['responses'])) {

                            foreach ($pathItem['responses'] as $key => $response) {
                                
                                $responseItenty = new HttpResponse($response);
                                
                                $responseErrors = $validator->getErrors($responseItenty);
                                
                                if (count($responseErrors)) {
                                    $errors[] = ['index' => $key, 'type' => 'paths.pathItems.response', 'errors' => $responseErrors];
                                    continue;
                                }
                                
                                $pathItemEntity->addResponse($responseItenty);
                            }
                        }


                        if (isset($pathItem['requestBody'])) {

                            $reqBodyItenty = new RequestBody($pathItem['requestBody']);

                            $reqBody = $validator->getErrors($reqBodyItenty);

                            if (count($reqBody)) {
                                $errors[] = ['index' => $key, 'type' => 'paths.pathItems.response', 'errors' => $reqBody];
                                continue;
                            }

                            $pathItemEntity->setRequestBody($reqBodyItenty);
                        }


                        $pathEntity->addPathItem($pathItemEntity);


                        if(isset($pathItem['tags'])) $pathItemEntity->addTags($pathItem['tags']);


                    }
                }

            }
        }

        $em = $doctrine->getManager();

        $em->persist($document);

        $em->flush();

        $responseData = [
            'success'    => true,
            'data'      => ['id' => $document->getId()]
        ];

        if (count($errors)) $responseData['errors'] = $errors;

        return new JsonResponse($responseData, Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'document_read')]
    public function read(string $id, OpenApiDocumentRepository $repo){

        if (!Uuid::isValid($id)) return new JsonResponse([ 'success' => false ], Response::HTTP_UNAUTHORIZED);

        $document = $repo->find($id);

        if (!$document) return new JsonResponse([ 'success' => false ], Response::HTTP_NOT_FOUND);

        return new JsonResponse([
            'success'    => true,
            'data'      => $document->toArray()
        ], Response::HTTP_OK);
    }
}
