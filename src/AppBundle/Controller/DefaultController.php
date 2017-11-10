<?php
namespace AppBundle\Controller;

header('Access-Control-Allow-Origin: *');

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Utils\RandomController;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request, RandomController $randomController)
    {
        $randomBeer = null;
        $randomBeer = $randomController->getRandomBeer();
        // $brewery = $randomBeer;

        return $this->render('default/index.html.twig', [
            'rand_beer' => $randomBeer,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/moreFromBrewery/{id}", name="more_from_brewery")
     */
    public function moreFromBreweryAction(Request $request, DataController $dataController, $id)
    {
        
        $brewery = $dataController->getBreweryInfo($request, $id)->getContent();
        $beers = $dataController->getBrewery($request, $id)->getContent();
        $breweryArray = json_decode($brewery);
        $beersArray = json_decode($beers);

        return $this->render('default/more_from_brewery.html.twig', [
            'brewery' => $breweryArray,
            'beers' => $beersArray,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}
