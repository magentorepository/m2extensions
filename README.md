# m2extensions
Collection of Magento2 extensions.

## Extension guidelines #

* Namespace of extension should be "Ktpl".
* Extension should well structured as describe below.
* Extension should have enable/disable facility from system config.
* Screenshots of frontend/admin need to be placed in Ktpl_Extension >> screenshots directory.

* Extension Structure
```
	|-- Ktpl_ExtensionName
		|-- app
			|-- code
				|-- Ktpl
					|-- ExtensionName
		|-- Readme.md
		|-- screenshots
```		
# Documentation format (Readme.md) #

# Ktpl_ExtensionName #

Intorduction of extension which define basic functionality provided by [Ktpl_ExtensionName].

### Changelog ###

* version 1.1.0 
** added new functionality

* version 1.0.5
** added new functionality

* version 1.0.4
** added new functionality

* version 1.0.2
** added new functionality

* version 1.0.1
** added new functionality

* version 1.0.0

### Version compatibility ###
* Compitible with magento 2.0.1-2.0.8, 2.1.0, 2.1.1

### How to Install ###

* php bin/magento cache:flush
* php bin/magento setup:upgrade
* php bin/magento setup:static-content:deploy
* php bin/magento cache:flush

### Features ###

* deatailed feature list
* functionalities
* admin menu
* and frontend access url

### How do I get set up? ###

* Summary of set up
* Configuration
* Dependencies
* Database configuration
* How to run tests
* Deployment instructions

### How to use ###

* admin required configurations
* frontend prerequisites like extension can be useful if customer is logged in.

### What's next can be done? ###

* functionality is not provided in [Ktpl_ExtensionName]
* and can be improve in next version

### Who do I talk to? ###

* Repository owner or admin
