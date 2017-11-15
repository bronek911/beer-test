<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Utils\ValidationController;
use PHPUnit\Framework\TestCase;

class ValidationControllerTest extends TestCase
{
    public function testValidation()
    {
    	$validate = new ValidationController();
        $resultTrue = $validate->checkTextInput('123 - abc');
        $resultFalse = $validate->checkTextInput("'123 - abc");

        $this->assertTrue($resultTrue);
        $this->assertFalse($resultFalse);
    }
}
