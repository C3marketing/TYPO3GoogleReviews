
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
  }
  features {
    #skipDefaultArguments = 1
  }
  mvc {
    #callDefaultActionIfActionCantBeResolved = 1
  }
}

plugin.tx_sitgooglereviews._CSS_DEFAULT_STYLE (
    textarea.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    input.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    .tx-sit-googlereviews table {
        border-collapse:separate;
        border-spacing:10px;
    }

    .tx-sit-googlereviews table th {
        font-weight:bold;
    }

    .tx-sit-googlereviews table td {
        vertical-align:top;
    }

    .typo3-messages .message-error {
        color:red;
    }

    .typo3-messages .message-ok {
        color:green;
    }
)
