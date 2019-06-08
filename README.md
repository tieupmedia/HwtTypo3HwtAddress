# HwtTypo3HwtAddress
## Install Note:
Name the extension folder "hwt_address"!

## About:
This TYPO3 extension provides a modern address handling since TYPO3 6.x, established in 2014. It adds an flexible address record, model and repository to your TYPO3. Furthermore it provides a frontend plugin based on extbase and fluid with flexible customisation options.

## Features:

**Conceptual + Backend**

- Manage universal address records for persons or companies in backend
- Translatable records
- TYPO3's assets field for adding multimedia elements to addresses
- Relate addresses to addresses
- Relate addresses to pages (aktivate field in extension manager, [see docu](Documentation/FeatureDisplayRelatedToPage.md))
- Relate links to addresses, that allow flexible customization, e.g. for social/profile links.

**Plugin - Frontend**

- Plugin for list and single view and zip search in frontend
- Template-based handling and partial for "record wasn't found" in single view
- Selectable template variants for each plugin action. Just configure new variants selectable in flexform via page TSconfig. Add related partials for output in frontend.
- Advanced 'record not found' handling for single view. (Redirects to page or action, show a content element, show a standalone template, system's 'page not found' handler)


**Integration**

- Integrated ke_search indexer
- Namespaced Extbase extension
- Installable via Composer

## Versions:
- < 0.1.0 for TYPO3 6.2 - 7.6
- \>= 0.1.0 for TYPO3 7.6 - 8.7
- \>= 0.2.0 for TYPO3 8.7 - 9.5