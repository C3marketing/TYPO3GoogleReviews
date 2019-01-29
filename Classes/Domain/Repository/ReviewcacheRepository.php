<?php
namespace SteinbauerIT\SitGooglereviews\Domain\Repository;

/**
 * The repository for Revievcache
 */
class ReviewcacheRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    public function findAllActiveCaches() {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                [
                    $query->greaterThan('place_id', ""),
                    $query->lessThanOrEqual('lasthit', time() + 48*60*60)
                ]
            )
        );
        return $query->execute();
    }

}