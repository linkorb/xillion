<img src="assets/xillion.png" />

Xillion
=======

Xillion is an Attribute-based Resource Framework.

It allows you to work with Resources and their collection of attributes.

## Use-cases:

* Use your entities in XACML, ABAC, OPA and other external policy-based frameworks
* Standardise the way remote objects from different sources are represented for integration purposes

## Definitions:

* Resource: representation of 1 real-world entity. Has a unique ID (in the form of a URL) and an array of Attributes
* Attribute: Defines a single attribute. Has a unique ID (in the form of a URL), description, an AttributeType and other metadata
* DataType: Data type supported by an Attribute (i.e. string, int, etc)
* ResourceRepository: Container for a set of Resources that allows you to search, get and set Resource instances in bulk
* ResourceContext: Container for a set of Resources Repositories. The root of the structure.
* Profile: A "Contract" or "Interface", specifying which attributes Resources of this type need to "implement'. A single Resource can implement multiple profiles simultaniously.

## Features:

* Specify a Attributes, DataTypes, Profiles and Resources to use in your projects in YAML configuration files
* Predefined instances of [xml schema datatypes](https://www.w3.org/TR/xmlschema-2/) are provided that are commonly used in XACML environments
* Resource Repositories: currently ArrayRepository, with plans for PDO and Elasticsearch based Repositories.
* Resource Loader
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

## Naming conventions:

* All identifiers are prefixed with a FQDN (Fully Qualified Domain Name). I.e. `core.xillion.cloud/display`
* The identifier FQDN is owned by the entity that defines the identifier (i.e. do not randomly defined resource or attribute identifiers with domain names that you do not own).
* Attribute identifiers do not specify a scheme (i.e. `http://`, `https://`, `file://` etc)
* Attribute identifiers do not contain a path prefix (i.e. do not prefix paths with `/xillion` etc)
* Identifiers are lower-case only, and allow dashes for word-spacing (i.e. `/some-example`)
* Any level of sub-paths is allowed in identifiers. The recommendation is to keep the levels to a minimum (i.e `x.example.web/a/b/c/d/e/f is allowed but discouraged)
* Profile identifiers are in a sub-path prefixed with `/profiles`.
* Data-type identifiers are in a sub-path prefixed with `/data-types`.
* Attribute identifiers do not use a prefix. (i.e. do not use prefix `/attributes`)
* Resource identifiers do not use a prefix. (i.e. do not use prefix `/resources`)
* Packages (FQDN) define either a set of attributes and profiles (library) -or- resources (content), not both.

## License

MIT. Please refer to the [license file](LICENSE) for details.

## Brought to you by the LinkORB Engineering team

<img src="http://www.linkorb.com/d/meta/tier1/images/linkorbengineering-logo.png" width="200px" /><br />
Check out our other projects at [linkorb.com/engineering](http://www.linkorb.com/engineering).

Btw, we're hiring!
