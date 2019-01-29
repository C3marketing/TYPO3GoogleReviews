<?php
namespace SteinbauerIT\SitGooglereviews\Domain\Repository;

/**
 * The repository for GoogleReviews
 */
class GoogleReviewRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * @param string $placeId
     * @param string $apiKey
     * @param string $lang
     * @param string $shortname
     * @param string $placename
     * @return array
     */
    public function showReviews($placeId,$apiKey,$lang,$shortname, $placename) {
        $xml = null;

        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
        $cacheRepository = $objectManager->get('SteinbauerIT\SitGooglereviews\Domain\Repository\ReviewcacheRepository');
        $reviewCache = $cacheRepository->findByPlaceId($placeId)->getFirst();

        if($reviewCache && $reviewCache->getLasthit() > (time() + 12*60*60) ) {
            $xml = simplexml_load_string($reviewCache->getResponse());
        } else {
            $xmlfile = 'https://maps.googleapis.com/maps/api/place/details/xml?placeid='.$placeId.'&fields=rating,reviews,url&key='.$apiKey.'&language='.$lang;
            $xml = simplexml_load_file($xmlfile);
            if($reviewCache == null) {
                $reviewCache = new \SteinbauerIT\SitGooglereviews\Domain\Model\Reviewcache;
                $reviewCache->setTitle($placename);
                $reviewCache->setPlaceId($placeId);
                $cacheRepository->add($reviewCache);
                $objectManager->get('TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface')->persistAll();
            }
        }

       // $xmlfile = 'https://maps.googleapis.com/maps/api/place/details/xml?placeid='.$placeId.'&fields=reviews&key='.$apiKey.'&language='.$lang;
        $check = $xml->status[0];
        if ($check=='INVALID_REQUEST') {
            $output = "Error! Place ID or API Key not correct.";
        } else {
            // update Cache

            $reviewCache->setResponse( $xml->asXML() );
            $reviewCache->setLasthit(time());
            $cacheRepository->update($reviewCache);
            $objectManager->get('TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface')->persistAll();

            $reviews = $xml->result[0]->review;
            $output = array();
            $output['rating'] = (string) $xml->result[0]->rating;
            $output['review'] = array();
            for($i=0; $i < count($reviews); $i++) {
                $rating = substr((string) $xml->result[0]->review[$i]->rating[0], 0, 1);
                $ratingStars = array();
                $diffStars = array();
                for($r=0; $r < intval($rating); $r++) {
                    $ratingArray = array('star' => 1);
                    array_push($ratingStars, $ratingArray);
                }
                $starDiff = 5-intval($rating);
                for($s=0; $s < intval($starDiff); $s++) {
                    $starDiffArray = array('star' => 1);
                    array_push($diffStars, $starDiffArray);
                }
                $author_name = (string) $xml->result[0]->review[$i]->author_name[0];
                if($shortname) {
                    $firstname = strtok($author_name, " ");
                    $split = explode(" ", $author_name);
                    $lastname = $split[count($split)-1];
                    $lastname = substr($lastname, 0, 1);
                    $author_name = $firstname.' '.$lastname.'.';
                }
                $content = array(
                    'text' => (string) $xml->result[0]->review[$i]->text[0],
                    'rating' => $ratingStars,
                    'stardiff' => $diffStars,
                    'profile_photo_url' => (string) $xml->result[0]->review[$i]->profile_photo_url[0],
                    'author_name' => $author_name,
                    'relative_time_description' => (string) $xml->result[0]->review[$i]->relative_time_description[0]);
                array_push($output['review'], $content);
            }
        }
        return $output;
    }



}
