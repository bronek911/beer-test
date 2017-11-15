<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Utils\RandomController;
use PHPUnit\Framework\TestCase;

class RandomControllerTest extends TestCase
{
    public function testRandoms()
    {
    	$key = '8ee73f8ad196bad6801099c189be9893';

		$random = new RandomController();
		$randStyleId = $random->getRandomStyle($key);
        $this->assertRegExp('/[0-9]+/', (string)$randStyleId);

		$randBeer = $random->randomBeer($key, $randStyleId);
        $this->assertObjectHasAttribute('id', $randBeer);

		$getRandBeer = $random->getRandomBeer($key);
        $this->assertObjectHasAttribute('id', $getRandBeer);
        $this->assertObjectHasAttribute('name', $getRandBeer);
        $this->assertObjectHasAttribute('description', $getRandBeer);
        $this->assertObjectHasAttribute('labels', $getRandBeer);
    }
}
