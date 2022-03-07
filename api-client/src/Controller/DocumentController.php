<?php

namespace App\Controller;

use App\Entity\PathItem;
use App\Repository\HttpMethodRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DocumentController extends AbstractController
{
    private $client;

    public function hydratePathItem(HttpMethodRepository $httpMethodRepository, string $method, string $summary, string $description, string $location){
        $PathItem = new PathItem();
        $PathItem->setSummary($summary ?? null); 
        $PathItem->setDescription($description ?? null);
        $HttpMethod = $httpMethodRepository->findOneBy(['method' => $method]);
        $PathItem->setHttpMethod($HttpMethod);
        
         return $PathItem; 
        } 
    
    public function hydrateOpenApiDocument( array $payload = [] ){
            
            
        return null; 
        } 

    #[Route('/document', name: 'app_document')]
    public function index(): Response
    {
        return new JsonResponse([ "Test"=> "test"]);
    }
    
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    
    
    
}
