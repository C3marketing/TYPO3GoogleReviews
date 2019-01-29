
plugin.tx_sitgooglereviews_googleratings {
  view {
    templateRootPaths.0 = EXT:sit_googlereviews/Resources/Private/Templates/
    templateRootPaths.1 = {$plugin.tx_sitgooglereviews_googleratings.view.templateRootPath}
    partialRootPaths.0 = EXT:sit_googlereviews/Resources/Private/Partials/
    partialRootPaths.1 = {$plugin.tx_sitgooglereviews_googleratings.view.partialRootPath}
    layoutRootPaths.0 = EXT:sit_googlereviews/Resources/Private/Layouts/
    layoutRootPaths.1 = {$plugin.tx_sitgooglereviews_googleratings.view.layoutRootPath}
  }
  persistence {
    apiKey = {$plugin.tx_sitgooglereviews_googleratings.persistence.apiKey}
    lang = {$plugin.tx_sitgooglereviews_googleratings.persistence.lang}
    #recursive = 1
    storagePid = 104
  }
  features {
    #skipDefaultArguments = 1
  }
  mvc {
    #callDefaultActionIfActionCantBeResolved = 1
  }
}