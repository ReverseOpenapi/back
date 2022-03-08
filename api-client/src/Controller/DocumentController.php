<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\OpenApiDocument;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Utils\Validator;
use App\Repository\OpenApiDocumentRepository;
use Ramsey\Uuid\Uuid;

#[Route('/document')]
class DocumentController extends AbstractController
{

    #[Route('', name: 'document_create', methods: ['POST'])]
    public function create(Request $request, ManagerRegistry $doctrine, Validator $validator): Response
    {
        $data = json_decode($request->getContent(), true) ?? [];

        $document = new OpenApiDocument($data);

        $errors = $validator->getErrors($document);

        if(count($errors)) {
            return new JsonResponse([
                'sucess' => false,
                'errors' => $errors
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $em = $doctrine->getManager();

        $em->persist($document);

        $em->flush();

        return new JsonResponse([
            'sucess'    => true,
            'data'      => $document->getId()
        ], Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'document_read')]
    public function read(string $id, OpenApiDocumentRepository $repo){

        if (!Uuid::isValid($id)) return new JsonResponse([ 'sucess' => false ], Response::HTTP_UNAUTHORIZED);

        $document = $repo->find($id);

        if (!$document) return new JsonResponse([ 'sucess' => false ], Response::HTTP_NOT_FOUND);

        return new JsonResponse([
            'sucess'    => true,
            'data'      => $document->toArray()
        ], Response::HTTP_OK);
    }
}
