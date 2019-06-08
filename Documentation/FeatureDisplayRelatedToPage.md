# HwtTypo3HwtAddress

## Feature: Display records related to the current page

### Description:
This extension provides the possibility, to relate address records directly to pages. This can be used, for example, if a page presents a business unit, which has it's own contact persons. Instead of building up equivalent category or sysfolder structures and inserting plugins which must be configured for each page, this feature provides a quicker way.

### Preparation:
You must enable it in the extension manager by a simple checkbox. If this is done, new relation fields show up in the page settings (extended tab) and the address records (relations tab).

### Usage:
Now you can relate page and address records via the relation group fields. To show a list of them in your page, there are two ways.

First you can set generally (or shrinked with TS conditions) the TypoScript constant ``plugin.tx_hwtaddress.settings.list.displayPageRelated = 1`` and insert an address plugin with list action as content element. If you don't configure address storage pages (you don't need to configure anything here) the plugin now displays the list of addresses related to the current page.

Even more comfort can be reached, if the position of the plugin is static in your theme. Then you can add the plugin pre-configured in a TypoScript library: 
```
in TypoScript:
page.XX < lib.tx_hwtaddress.pluginRelatedToPage

in Fluid templates:
<f:cObject typoscriptObjectPath="lib.tx_hwtaddress.pluginRelatedToPage"/>
```
(In this way you don't need to set the constant mentioned for the first way, which prevents from any effects to the normal plugins.)
