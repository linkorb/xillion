<img src="assets/xillion.png" />

Xillion
=======

Xillion is an Attribute-based Resource Framework.

It allows you to work with Resources and their collection of attributes.

## Use-cases:

* Use your entities in XACML, ABAC, OPA and other external policy-based frameworks
* Standardise the way remote objects from different sources are represented for integration purposes

## Definitions:

* AttributeDefinition: Defines a single attribute. Has a unique ID (in the form of a URL), an AttributeType and other metadata
* Attribute: An instance of an AttributeDefinition containing an array of values
* AttributeType: Data type supported by an AttributeDefinition (i.e. string, int, etc)
* Resource: representation of 1 real-world entity. Has a unique ID (in the form of a URL), a array of Attributes and optionally a array of ResourceTypes
* ResourceContext: Container for a set of Resources that allows you to search, validate and explore Resource instances in bulk
* ResourceType: A "Contract" or "Interface", specifying which attributes Resources of this type need to "implement'. A single Resource can implement multiple types simultaniously.

## Features:

* Specify a Attribute Definitions to use in your projects (collected into an AttributeDefinitionRegistry)
* Specify a Resource Types to use in your projects (collected into an ResourceTypeRegistry)
* Predefined instances of [xml schema datatypes](https://www.w3.org/TR/xmlschema-2/) that are commonly used in XACML environments
* Loaders for Attribute Definitions, Attribute Types, Resource Types and Resources
* Resource Resolver that can resolve pre-populated Resources with their attributes and types from objects through various means (currently direct and provider-based)
* Resolve Resources directly from your entities: Quick and simple method if you "own" those entities.
* Resolve Resources through a ResourcesProvider: Useful to extract attributes for entities from external libraries.
* Collect your resources in a single Resource Context for bulk operations
* Validate one Attribute, a Resource or an entire Resource Context

## Inspiration

* XACML (+JSON profile)
* LDAP
* FHIR
* Open Policy Agent
* SAML2

## License

MIT. Please refer to the [license file](LICENSE) for details.

## Brought to you by the LinkORB Engineering team

<img src="http://www.linkorb.com/d/meta/tier1/images/linkorbengineering-logo.png" width="200px" /><br />
Check out our other projects at [linkorb.com/engineering](http://www.linkorb.com/engineering).

Btw, we're hiring!
