<?php
namespace AppBundle\Controller;

header('Access-Control-Allow-Origin: *');

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Utils\RandomController;
use Symfony\Component\HttpFoundation\JsonResponse;

class DataController extends Controller
{
    /**
     * Gets random beer in JSON response.
     *
     * @Route("/getBeer", name="get_beer")
     */
    public function getBeer(Request $request, RandomController $randomController)
    {
        $randBeer = null;

        $randomBeer = $randomController->getRandomBeer();

        return new JsonResponse($randomBeer, 200, array(
            'Content-Type' => 'application/json'
        ));    
    }

    /**
     * Gets brewry beers.
     *
     * @Route("/getBrewery/{id}", name="brewery_info")
     */
    public function getBreweryInfo(Request $request, $id)
    {
        $brewery = null;

        $brewery = file_get_contents("http://api.brewerydb.com/v2/brewery/" . $id . "?key=8ee73f8ad196bad6801099c189be9893");
        $breweryArray = json_decode($brewery);

        return new JsonResponse($breweryArray, 200, array(
            'Content-Type' => 'application/json'
        ));    
    }

    /**
     * Gets brewry beers.
     *
     * @Route("/getBreweryBeers/{id}", name="get_brewery")
     */
    public function getBrewery(Request $request, $id)
    {
        $brewery = null;

        $beers = file_get_contents("http://api.brewerydb.com/v2/brewery/" . $id . "/beers?key=8ee73f8ad196bad6801099c189be9893");
        $beersArray = json_decode($beers);

        return new JsonResponse($beersArray, 200, array(
            'Content-Type' => 'application/json'
        ));    
    }
}
