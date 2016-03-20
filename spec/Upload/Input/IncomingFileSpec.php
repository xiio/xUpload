<?php

namespace spec\xiio\xUpload\Upload\Input;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IncomingFileSpec extends ObjectBehavior
{

//methods
	function it_has_extension()
	{
		$this->getExtension()->shouldReturn('php');
	}

	function it_has_mimetype()
	{
		$this->getMimeType()->shouldReturn('text/x-php');
	}

	function it_has_name()
	{
		$this->getName()->shouldReturn('file.php');
	}

	function it_has_path()
	{
		$this->getPath()->shouldReturn(__FILE__);
	}

	function it_has_size(){
		$my_size = filesize(__FILE__);
		$this->getSize()->shouldReturn($my_size);
	}

	function it_is_initializable()
	{
		$this->shouldHaveType('xiio\xUpload\Upload\Input\IncomingFile');
		$this->shouldImplement('xiio\xUpload\Upload\Abstraction\IncomingFileInterface');
	}

	function it_is_uploaded_file()
	{
		$this->isUploaded()->shouldReturn(FALSE);
	}

	function let(){
		$this->beConstructedWith('file.php', __FILE__);
	}

}