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
     * reviewcacheRepository
     *
     * @var \SteinbauerIT\SitGooglereviews\Domain\Repository\ReviewcacheRepository
     * @inject
     */
    protected $reviewcacheRepository = null;

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
        $this->view->assign('output', $this->googleReviewRepository->showReviews($placeId,$apiKey,$lang,$shortname, $this->settings['placename']));
    }

    /**
     * action showAllCaches
     *
     * @return void
     */
    public function showAllCachesAction()
    {
        $shortname = $this->settings['shortname'];
        $avgCnt = 0;
        $avgSum = 0;

        $allCachedReviews = $this->reviewcacheRepository->findAllActiveCaches();
        $reviews = array("places" => array(), "review" => array());
        foreach($allCachedReviews as $cacheEntry) {
            $reviews['places'][$cacheEntry->getPlaceId()]['title'] = $cacheEntry->getTitle();

            $xml = simplexml_load_string($cacheEntry->getResponse());
            $reviews['places'][$cacheEntry->getPlaceId()]['rating'] = (string)$xml->result[0]->rating;
            $avgCnt ++;
            $avgSum += floatval($xml->result[0]->rating);

            for ($i = 0; $i < count( $xml->result[0]->review); $i++) {
                $rating = substr((string)$xml->result[0]->review[$i]->rating[0], 0, 1);
                $ratingStars = array();
                $diffStars = array();
                for ($r = 0; $r < intval($rating); $r++) {
                    $ratingArray = array('star' => 1);
                    array_push($ratingStars, $ratingArray);
                }
                $starDiff = 5 - intval($rating);
                for ($s = 0; $s < intval($starDiff); $s++) {
                    $starDiffArray = array('star' => 1);
                    array_push($diffStars, $starDiffArray);
                }
                $author_name = (string)$xml->result[0]->review[$i]->author_name[0];
                if ($shortname) {
                    $firstname = strtok($author_name, " ");
                    $split = explode(" ", $author_name);
                    $lastname = $split[count($split) - 1];
                    $lastname = substr($lastname, 0, 1);
                    $author_name = $firstname . ' ' . $lastname . '.';
                }
                $content = array(
                    'place' => $cacheEntry->getPlaceId(),
                    'text' => (string)$xml->result[0]->review[$i]->text[0],
                    'rating' => $ratingStars,
                    'stardiff' => $diffStars,
                    'profile_photo_url' => (string)$xml->result[0]->review[$i]->profile_photo_url[0],
                    'author_name' => $author_name,
                    'relative_time_description' => (string)$xml->result[0]->review[$i]->relative_time_description[0],
                    'timestmap' => (string)$xml->result[0]->review[$i]->time[0]
                );

                array_push($reviews['review'], $content);
            }
        }
        usort($reviews['review'], function($a, $b) {
            return $b['timestmap'] - $a['timestmap'];
        });

        $this->view->assign('avg', array("cnt" => $avgCnt, "overallAvg" => round($avgSum/$avgCnt, 1)));
        $this->view->assign('reviews', $reviews);
    }
}
