<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse, Response};
use Ramsey\Uuid\Uuid;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\HeaderUtils;



#[Route('/api/test')]
#[OA\Tag(name: "Test")]
class TestController extends AbstractController
{

    #[Route('/download/{id}', name:'functional_tests_download', methods: ['GET'])]
    public function retrieve(FileSystem $fs, string $id) : Response
    {

        if (!Uuid::isValid($id)) return new JsonResponse([ 'success' => false ], Response::HTTP_UNAUTHORIZED);

        $filename =  'functional-test/' . $id . '.json';

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

}
