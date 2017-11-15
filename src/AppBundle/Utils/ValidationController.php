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

class ValidationController
{
	public function checkTextInput($phrase) {

        // check if string contain only letters, numbers, hyphens and spaces
		if(preg_match("/^[A-Za-z0-9-\s]+$/", $phrase)){
			return true;
		} else {
			return false;
		}

	}
}