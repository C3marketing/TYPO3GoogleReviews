<?php
namespace SteinbauerIT\SitGooglereviews\Controller;

/**
 * GoogleReviewController
 */
class GoogleReviewController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * googleReviewRepository
     *
     * @var \SteinbauerIT\SitGooglereviews\Domain\Repository\GoogleReviewRepository
     * @inject
     */
    protected $googleReviewRepository = null;

    /**
     * action show
     *
     * @return void
     */
    public function showAction()
    {
        $apiKey = $GLOBALS['TSFE']->tmpl->setup["plugin."]["tx_sitgooglereviews_googleratings."]["persistence."]["apiKey"];
        $placeId = $this->settings['placeid'];
        $pluginLang = $this->settings['lang'];
        $shortname = $this->settings['shortname'];
        if($pluginLang) {
            $lang = $pluginLang;
        } else {
            $lang = $GLOBALS['TSFE']->tmpl->setup["plugin."]["tx_sitgooglereviews_googleratings."]["persistence."]["lang"];
        }
        $this->view->assign('output', $this->googleReviewRepository->showReviews($placeId,$apiKey,$lang,$shortname));
    }

}
