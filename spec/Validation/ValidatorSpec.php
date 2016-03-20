<?php

namespace spec\xiio\xUpload\Validation;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use xiio\xUpload\Abstraction\File;
use xiio\xUpload\Validation\Abstraction\ValidationRuleInterface;
use xiio\xUpload\Validation\Abstraction\ValidatorInterface;

class ValidatorSpec extends ObjectBehavior
{
//methods
    function it_can_add_rule()
    {
        $rule = new DummyRule(TRUE);
        $this->addRule($rule);
        $this->getRules()->shouldHaveCount(1);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('xiio\xUpload\Validation\Validator');
    }

    function it_should_be_valid_with_no_rules()
    {
        $this->isValid()->shouldBe(TRUE);
    }

    function it_should_fail_if_any_rule_not_valid()
    {
        $rule = new DummyRule(TRUE);
        $rule1 = new DummyRule(FALSE);
        $this->addRule($rule);
        $this->addRule($rule1);
        $this->isValid()->shouldReturn(FALSE);
    }

    function it_should_has_rules()
    {
        $this->getRules()->shouldBeArray();
    }

    function it_should_pass_if_every_rule_true()
    {
        $rule = new DummyRule(TRUE);
        $rule1 = new DummyRule(TRUE);
        $this->addRule($rule);
        $this->addRule($rule1);
        $this->isValid()->shouldReturn(TRUE);
    }

}


class DummyRule implements ValidatorInterface
{

    private $return;

    /**
     * DummyRule constructor.
     *
     * @param $return
     */
    public function __construct($return)
    {
        $this->return = $return;
    }

    /**
     * Validate file
     *
     * @param \xiio\xUpload\Abstraction\File $file
     *
     * @return boolean
     */
    public function isValid(File $file)
    {
        return $this->return;
    }

    public function addRule(ValidationRuleInterface $rule)
    {
        // TODO: Implement addRule() method.
    }
}
