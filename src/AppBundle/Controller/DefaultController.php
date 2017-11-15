<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Search;
use AppBundle\Form\SearchType;
use AppBundle\Utils\RandomController;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\FormBuilderInterface;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request, DataController $dataController)
    {

        $key = $this->getParameter('homepage.api_key');
        $errors = [];

        $randomBeer = $this->get('random_service')->getRandomBeer($key);

        $returnData = [
            'rand_beer' => $randomBeer,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ];
        
        if($request->isMethod('POST')){

            $postData = $request->request->all();

            if(isset($postData['brewery-id']) && $postData['brewery-id']!==null){
                $phrase = $postData['brewery-id'];
                $category = 'brewery';
                $search = $dataController->getBrewery($request, $key, $phrase)->getContent();
                $searchData = json_decode($search);
                $prevRandomBeerId = $postData['prev-rand-beer-id'];
                $beer = $dataController->getBeerById($request, $key, $prevRandomBeerId)->getContent();
                $beerArray = json_decode($beer);

                $returnData['searchPhrase'] = $phrase;
                $returnData['searchCategory'] = $category;
                $returnData['searchData'] = $searchData;
                $returnData['rand_beer'] = $beerArray->data;
            } else {
                $phrase = trim($postData['phrase']);
                if ($this->get('validation_service')->checkTextInput($phrase) == false) {
                    $errors['input-validation'] = 1;
                    $returnData['errors'] = $errors;
                } else {
                    $category = $postData['searchCategory'];
                    $search = $dataController->searchAction($request, $key, $phrase, $category)->getContent();
                    $searchData = json_decode($search);
                    $returnData['searchPhrase'] = $phrase;
                    $returnData['searchCategory'] = $category;
                    $returnData['searchData'] = $searchData;
                }
            }
        }
        return $this->render('default/index.html.twig', $returnData);
    }

    /**
     * @Route("/beer/{id}", name="deer_description")
     */
    public function beerAction(Request $request, DataController $dataController, $id)
    {
        $key = $this->getParameter('homepage.api_key');
        $beer = $dataController->getBeerById($request, $key, $id)->getContent();
        $beerArray = json_decode($beer);

        return $this->render('default/beer.html.twig', [
            'beer' => $beerArray,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/brewery/{id}", name="more_from_brewery")
     */
    public function moreFromBreweryAction(Request $request, DataController $dataController, $id)
    {
        $key = $this->getParameter('homepage.api_key');
        $brewery = $dataController->getBreweryInfo($request, $key, $id)->getContent();
        $beers = $dataController->getBrewery($request, $key, $id)->getContent();
        $breweryArray = json_decode($brewery);
        $beersArray = json_decode($beers);

        return $this->render('default/more_from_brewery.html.twig', [
            'brewery' => $breweryArray,
            'beers' => $beersArray,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}
