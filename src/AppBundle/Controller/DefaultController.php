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

        $randBeer = null;

        do{
            $randStyleId = $randomController->getRandomStyle();
            $randBeer = $randomController->getRandomBeer($randStyleId);
            $isSet = isset($randBeer->description);
        } while ($isSet == false);


        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'rand_beer' => $randBeer,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}
