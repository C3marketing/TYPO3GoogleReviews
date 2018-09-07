
plugin.tx_sitgooglereviews_googleratings {
  view {
    # cat=plugin.tx_sitgooglereviews_googleratings/file; type=string; label=Path to template root (FE)
    templateRootPath = EXT:sit_googlereviews/Resources/Private/Templates/
    # cat=plugin.tx_sitgooglereviews_googleratings/file; type=string; label=Path to template partials (FE)
    partialRootPath = EXT:sit_googlereviews/Resources/Private/Partials/
    # cat=plugin.tx_sitgooglereviews_googleratings/file; type=string; label=Path to template layouts (FE)
    layoutRootPath = EXT:sit_googlereviews/Resources/Private/Layouts/
  }
  persistence {
    # cat=plugin.tx_sitgooglereviews_googleratings//a; type=string; label=Google Places API Key
    apiKey =
    # cat=plugin.tx_sitgooglereviews_googleratings//a; type=string; label=Language
    lang = en
  }
}
