
# HwtTypo3HwtAddress

## Configuration: Use TYPO3 routing to build static/speaking urls

### Usage:
Configure a custom routing for address records in the site config: https://docs.typo3.org/m/typo3/reference-coreapi/main/en-us/ApiOverview/Routing/AdvancedRoutingConfiguration.html

### Examples:
Speaking url for single view:
```yaml
routeEnhancers:
  HwtAddress:
    type: Extbase
    limitToPages:
	  - <your uid of single page>
    extension: HwtAddress
    # use the plugin namespace (without tx_extensionkey prefix)!
    plugin: Address
    routes:
      -
        routePath: '/{address_title}'
        _controller: 'Address::single'
        _arguments:
          address_title: address
    aspects:
      address_title:
        # Use single field of address record as path segment:
        type: PersistedAliasMapper
        tableName: tx_hwtaddress_domain_model_address
        routeFieldName: lastname

        # - OR -

        # Use multiple fields of address record as path segment:
        #type: PersistedPatternMapper
        #tableName: tx_hwtaddress_domain_model_address
        #routeFieldPattern: '^(?P<firstname>.+)-(?P<lastname>.+)-(?P<uid>\d+)$'
        #routeFieldResult: '{firstname}-{lastname}-{uid}'
```
