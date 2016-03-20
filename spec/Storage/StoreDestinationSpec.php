<?php

namespace spec\xiio\xUpload\Storage;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StoreDestinationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('xiio\xUpload\Storage\StoreDestination');
    }

    function let(){
        $this->beConstructedWith(__DIR__);
    }

}
