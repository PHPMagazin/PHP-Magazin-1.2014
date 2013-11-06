<?php
class Shopware_Plugins_Frontend_SloganOfTheDay_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{
    /**
     * plugin install function
     *
     * @return bool
     */
    public function install()
    {
        $form = $this->Form();
        $form->setElement(
            'textarea',
            'slogans',
            array(
                'label' => 'Slogans',
                'description' => 'Geben Sie die Slogans mit einem Semikolon getrennt an (Bsp.: "Slogan 1;Slogan2")',
                'value' =>'mmmmh... shopware;shopware ist mein Lebenselixier;shopware weiss, was Frauen wünschen;shopware flirtet gern',
                'scope' => Shopware\Models\Config\Element::SCOPE_SHOP
            )
        );

        $this->subscribeEvent(
            'Enlight_Controller_Action_PostDispatch_Frontend_Index',
            'onPostDispatchIndex'
        );

        return TRUE;
    }

    /**
     * Function which is executed on each frontend page
     *
     * @param Enlight_Event_EventArgs $arguments Standard Arguments
     */
    public function onPostDispatchIndex(Enlight_Event_EventArgs $arguments)
    {
        $view = $arguments->getSubject()->View();
        $view->addTemplateDir($this->Path() . 'Views/');
        $view->extendsTemplate('frontend/plugins/slogan_of_the_day/index.tpl');
        $view->assign('slogan', $this->getRandomSlogan());
    }

    /**
     * returns an random slogan
     *
     * @return string
     */
    public function getRandomSlogan()
    {
        $slogans = $this->Config()->get('slogans', array());
        if (empty($slogans)) {
            return 'No slogans configured';
        } else {
            $slogans = explode(';', $slogans);
            $index = rand(0, count($slogans) - 1);
            return $slogans[$index];
        }
    }

    /**
     * getInfo function for information
     * @return array
     */
    public function getInfo()
    {
        return array(
            'version' => $this->getVersion(),
            'label' => $this->getLabel(),
            'author' => 'best it Consulting GmbH & Co. KG',
            'support' => 'http://www.bestit-online.de',
            'link' => 'http://www.bestit-online.de',
            'copyright' => 'best it Consulting GmbH & Co. KG',
            'description' => '<iframe src="http://cdn.bestit-online.de/plugin_description/" width="630" height="110"></iframe>'
        );
    }

    /**
     * getVersion function for Version information
     * @return string
     */
    public function getVersion()
    {
        return '1.0.0';
    }

    /**
     * getLabel function returns the label
     * @return string
     */
    public function getLabel()
    {
        return 'Slogan of the Day';
    }


}
