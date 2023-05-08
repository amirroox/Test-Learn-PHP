<?php

use App\Models\Users;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase {


    function test_example(){
        $user1 = new Users();
        $user1->setFirstName("Amir");
        $this->assertEquals( "Amir" , $user1->getFirstName());

    }

}



