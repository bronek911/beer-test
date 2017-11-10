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

class RandomController
{

	public function getRandomStyle()
    {

    	//BEER STYLES
        //For finding beers we need to pass at least one argument. I've decided to get full list of beer styles and searching a random beer by passing random style ID. Here I'm checking size of styles array to know what is the maximum for mt_rand function.
        //////////////////////////////////////////
        $styles = file_get_contents("http://api.brewerydb.com/v2/styles?key=8ee73f8ad196bad6801099c189be9893");
        $stylesArray = json_decode($styles);

        $arrayLength = sizeof($stylesArray->data);
        $randStyleId = mt_rand(0, $arrayLength-1);

        return $randStyleId;
    }

    public function randomBeer($randStyleId){

    	//Random beer
        //////////////////////////////////////////
        $beers = file_get_contents("http://api.brewerydb.com/v2/beers?styleId=" . $randStyleId . "&order=random&hasLabels=Y&withBreweries=Y&key=8ee73f8ad196bad6801099c189be9893");
        $beersArray = json_decode($beers);

        $randomBeer = $beersArray->data[0];

        return $randomBeer;
    }

    public function getRandomBeer(){

    	do{
            $randomBeer = $this->randomBeer($this->getRandomStyle());
            $isSet = isset($randomBeer->description);
        } while ($isSet == false);

        return $randomBeer;
    }

}