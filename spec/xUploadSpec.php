<?php

namespace spec\xiio\xUpload;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class xUploadSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('xiio\xUpload\xUpload');
    }
}
