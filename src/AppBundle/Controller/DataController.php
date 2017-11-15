<?php
namespace AppBundle\Controller;

use AppBundle\Utils\RandomController;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DataController extends Controller
{
    /**
     * Gets random beer in JSON response.
     *
     * @Route("/getBeer/{id}", name="get_beer_by_id")
     */
    public function getBeerById(Request $request, $key, $id)
    {
        $beer = null;

        $beer = file_get_contents("http://api.brewerydb.com/v2/beer/" . $id . "?withBreweries=Y&key=" . $key);
        $beerArray = json_decode($beer);

        return new JsonResponse($beerArray, 200, array(
            'Content-Type' => 'application/json'
        ));    
    }

    /**
     * Gets random beer in JSON response.
     *
     * @Route("/getBeer", name="get_beer")
     */
    public function getBeer(Request $request)
    {
        $randBeer = null;
        $randomBeer = $this->get('random_service')->getRandomBeer($this->container->getParameter('homepage.api_key'));

        return new JsonResponse($randomBeer, 200, array(
            'Content-Type' => 'application/json'
        ));    
    }

    /**
     * Gets brewry beers.
     *
     * @Route("/getBrewery/{id}", name="brewery_info")
     */
    public function getBreweryInfo(Request $request, $key, $id)
    {
        $brewery = null;

        $brewery = file_get_contents("http://api.brewerydb.com/v2/brewery/" . $id . "?key=". $key);
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
    public function getBrewery(Request $request, $key, $id)
    {
        $brewery = null;

        $beers = file_get_contents("http://api.brewerydb.com/v2/brewery/" . $id . "/beers?key=" . $key);
        $beersArray = json_decode($beers);

        return new JsonResponse($beersArray, 200, array(
            'Content-Type' => 'application/json'
        ));    
    }

    /**
     * Search.
     *
     * @Route("/search", name="search")
     */
    public function searchAction(Request $request, $key, $phrase, $category)
    {
        $item = null;

        $item = file_get_contents("http://api.brewerydb.com/v2/search/?q=" . $phrase . "&type=" . $category . "&withBreweries=Y&key=". $key);
        $itemArray = json_decode($item);

        return new JsonResponse($itemArray, 200, array(
            'Content-Type' => 'application/json'
        ));    
    }
}
