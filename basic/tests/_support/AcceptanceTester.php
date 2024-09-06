<?php
use PHPUnit\Framework\Assert;



/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;
    use \Codeception\Util\Shared\Asserts;

    /**
    * Define custom actions here
    */

    public function scrollToElementIfNotVisible($selector, $maxAttempts = 10)
    {
        $attempt = 0;

        while (!$this->isElementVisible($selector) && $attempt < $maxAttempts) {
            $this->scrollTo($selector);
            $attempt++;
        }
    }

    public function isElementVisible($selector)
    {
        return $this->executeJS("return document.querySelector('$selector').getBoundingClientRect().top < window.innerHeight;");
    }

    public function isElementNotVisible($selector)
    {
        return $this->executeJS("return document.querySelector('$selector').getBoundingClientRect().top < window.innerHeight;");
    }

    //Asserts::assertEquals

    


}
