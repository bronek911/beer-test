<?php
namespace AppBundle\Controller;

header('Access-Control-Allow-Origin: *');

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Utils\RandomController;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request, RandomController $randomController)
    {
        $randomBeer = null;

        do{

            $randomStyleId = $randomController->getRandomStyle();
            $randomBeer = $randomController->getRandomBeer($randomStyleId);
            $isSet = isset($randomBeer->description);
        } while ($isSet == false);

        return $this->render('default/index.html.twig', [
            'rand_beer' => $randomBeer,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }


    /**
     * Gets random beer in JSON response.
     *
     * @Route("/getBeer", name="get_beer")
     */
    public function getBeer(Request $request, RandomController $randomController)
    {
        $randBeer = $randomController->getRandomBeer($randomController->getRandomStyle());

        return $this->render('default/getBeer.html.twig', array(
            'beer' => $randBeer,
        ));
    }
}
