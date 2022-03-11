<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse, Response};
use Ramsey\Uuid\Uuid;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\Routing\Annotation\Route;
use Gaufrette\Filesystem;


#[Route('/api/test')]
#[OA\Tag(name: "Functional Test")]
class TestController extends AbstractController
{

    #[Route('/download/{id}', name:'functional_tests_download', methods: ['GET'])]
    public function retrieve(string $id, FileSystem $fs) : Response
    {

        if (!Uuid::isValid($id)) return new JsonResponse([ 'success' => false ], Response::HTTP_UNAUTHORIZED);

        $filename =  $id . '.zip';

        if (!$fs->has('functional-test/' . $filename)) return new JsonResponse([ 'success' => false ], Response::HTTP_NOT_FOUND);

        $file = $fs->get('functional-test/' . $filename);
        $response = new Response($file->getContent());

        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            $filename
        );


        $response->headers->set('Content-Disposition', $disposition);
        return $response;
    }

}
