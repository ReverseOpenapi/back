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

#[Route('/document')]
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
    #[Route('', name: 'document_create', methods: ['POST'])]
    public function create(Request $request, ManagerRegistry $doctrine, Validator $validator): JsonResponse
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

        return new JsonResponse([
            'success'    => true,
            'data'      => ['id' => $document->getId()]
        ], Response::HTTP_OK);
    }

    /**
     * Retrieve an Open Api Document by it's id
     *
     * @param  string $id the id of the document
     * @param  OpenApiDocumentRepository $repo
     * @return JsonResponse
     */
    #[Route('/{id}', name: 'document_read')]
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
