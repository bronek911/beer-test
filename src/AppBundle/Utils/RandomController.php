<?php
/**
 * Created by PhpStorm.
 * User: Micha³
 * Date: 9/21/2017
 * Time: 01:05 PM
 */

namespace AppBundle\Utils;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RandomController extends Controller
{

	public function getRandomStyle($key)
    {
    	//BEER STYLES
        //For finding beers we need to pass at least one argument. I've decided to get full list of beer styles and searching a random beer by passing random style ID. Here I'm checking size of styles array to know what is the maximum for mt_rand function.
        //////////////////////////////////////////
        $styles = file_get_contents("http://api.brewerydb.com/v2/styles?key=". $key);
        $stylesArray = json_decode($styles);

        $arrayLength = sizeof($stylesArray->data);
        $randStyleId = mt_rand(0, $arrayLength-1);

        return $randStyleId;
    }

    public function randomBeer($key, $randStyleId){

    	//Random beer
        //////////////////////////////////////////
        do {
            $beers = file_get_contents("http://api.brewerydb.com/v2/beers?styleId=" . $randStyleId . "&order=random&hasLabels=Y&withBreweries=Y&key=" . $key);
            $beersArray = json_decode($beers);
        } while (!isset($beersArray->data[0]));

        $randomBeer = $beersArray->data[0];

        return $randomBeer;
    }

    public function getRandomBeer($key){

    	do{
            $randomBeer = $this->randomBeer($key, $this->getRandomStyle($key));
            $isSet = isset($randomBeer->description);
        } while ($isSet == false);

        return $randomBeer;
    }

}