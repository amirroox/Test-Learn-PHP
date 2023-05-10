<?php

use App\Models\Users;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase {


    function test_example(){
        $user1 = new Users();
        $user1->setFirstName("Amir");
        $this->assertEquals( "Amir" , $user1->getFirstName());
    }
    function test_exampletwo(){
        $user1 = new Users();
        $user1->setFirstName("Amir");
        $user1->setLastName("Roox");
        $this->assertEquals( "Amir" , $user1->getFirstName());
        $user1->SetFullName();
        echo $user1->getFullName();
    }
    /**
     *
     */

}



