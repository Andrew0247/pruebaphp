<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;

class LibrosController extends AbstractController
{
    /**
     * @Route("/libros", name="libros")
     */
    public function index(Request $request): Response
    {
        $client = HttpClient::create();
        $autor = $request->get('autor');
        $año = $request->get('año');

        if($autor != '' or $año != ''){

            $url = "https://www.etnassoft.com/api/v1/get/?book_author=$autor&publisher_date=$año";
            $content = $client->request('GET', $url);
            $cuerpo = $content->getContent();
            $decodificacion = json_decode($cuerpo);

        }else{

            $content = $client->request('GET', 'https://www.etnassoft.com/api/v1/get/?category=libros_programacion');
            $cuerpo = $content->getContent();
            $decodificacion = json_decode($cuerpo);
        
        }
            
        return $this->render('libros/index.html.twig', [
            'controller_name' => 'LibrosController',
           'contenido' => $decodificacion,
        ]);
    }

    /**
     * @Route("/verLibro/{id}", name="ver_libro")
     */
    public function ver(string $id): Response
    {
        $client = HttpClient::create();
        $url = "https://www.etnassoft.com/api/v1/get/?id=$id";
        $content = $client->request('GET', $url);
        $cuerpo = $content->getContent();
        $decodificacion = json_decode($cuerpo);
        // print_r($decodificacion);

        return $this->render('libros/ver_libro.html.twig', [
            'controller_name' => 'LibrosController',
           'contenido' => $decodificacion,
        ]);
    }

    /**
     * @Route("/filtros", name="filtros")
     */
    public function filtros(): Response
    {

        return $this->render('libros/filtros.html.twig', [
            'controller_name' => 'LibrosController',
        ]);
    }
}
