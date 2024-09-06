<?php

#use AcceptanceTester;
use PHPUnit\Framework\Assert;
use app\modules\takedatam\models\Fieldsforms;


use yii\helpers\Url;


class DocumentCest
{
    /**
     * @var \FunctionalTester
     */

    public string $urlRoute = '/takedatam/default/document';

    protected $tester;

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute($this->urlRoute));//'/takedatam/default/paidedu'
    }

    #protected function _before(AcceptanceTester $I)
    #{
    #    Dataforms::deleteAll();
    #}

    protected function _after(AcceptanceTester $I)
    {
    }
    
    public function testDocumentAction(AcceptanceTester $I)
    {
        $I->amOnPage($this->urlRoute);
        $I->see('Home');
    }

    public function submitValidData(AcceptanceTester $I)
    {
        $I->amOnPage($this->urlRoute);
        $buttons = $I->grabMultiple('button#add_row');
        $I->click(['css' => 'button#add_row:nth-of-type(1)']);

        $I->fillField(['xpath' => '//*[@id="main"]/div/form/div[1]/div[1]/input'], 'php-webdriver');
        $I->attachFile(['xpath' => '//*[@id="File0"]'], 'test.png');

        //$I->fillField(['xpath' => '//*[@id="main"]/div/form/div[1]/div[1]/input'], 'php-webdriver');
        //$I->attachFile(['xpath' => '//*[@id="File0"]'], 'test.png');

        

        $elementSelector = '#main > div > form > div.form-group > button';

        $I->scrollToElementIfNotVisible($elementSelector);
        $I->click($elementSelector);

        $I->seeInField(['xpath' => '//*[@id="main"]/div/form/div[1]/div[1]/input'],'php-webdriver');


        //*[@id="main"]/div/form/div[1]/div[1]/div[1]/a
        //$actualValue = $I->grabValueFrom(['xpath' => '//*[@id="main"]/div/form/div[1]/div[1]/div[1]/a']);

        //$idDoc = Fieldsforms::findOne(11);
        //var_dump($actualValue);
        //$expected = 'http://127.0.0.1:9000/testbucket/ustav'.$idDoc;
        //Assert::assertEquals($actualValue, $expected);

    }
    //*[@id="delrow"]
    /*
    public function deleteData(AcceptanceTester $I)
    {
        $I->click(['xpath' => '//*[@id="delrow"]']);
        $I->acceptPopup();
        $I->dontSeeElement(['xpath'=>'//*[@id="main"]/div/form/div[1]/div[1]/label']);
    }
    */
}