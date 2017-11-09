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
        $curl_style = curl_init();
        curl_setopt($curl_style, CURLOPT_HEADER, 0);
        curl_setopt($curl_style, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_style, CURLOPT_URL, "http://api.brewerydb.com/v2/styles?key=395d69145020a56c0dfcc142e2c50a19");

        $result = curl_exec($curl_style);
        curl_close($curl_style);

        $array = json_decode($result);

        //For finding beers we need to pass at least one argument. I've decided to get full list of beer styles and searching a random beer by passing random style Id. Here I'm checking size of styles array to know what is the maximum for mt_rand function
        $arrayLength = sizeof($array->data);
        $randStyleId = mt_rand(0, $arrayLength-1);

        return $randStyleId;
    }

    public function getRandomBeer($randStyleId){

    	//Random beer
        //////////////////////////////////////////
        $curl_beer = curl_init();
        curl_setopt($curl_beer, CURLOPT_HEADER, 0);
        curl_setopt($curl_beer, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_beer, CURLOPT_URL, "http://api.brewerydb.com/v2/beers?styleId=" . $randStyleId . "&order=random&hasLabels=Y&key=395d69145020a56c0dfcc142e2c50a19");

        $beers_json = curl_exec($curl_beer);
        curl_close($curl_beer);

        $beersArray = json_decode($beers_json);

        $randomBeer = $beersArray->data[0];

        return $randomBeer;
    }

}