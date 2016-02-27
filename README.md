# Live templates for JetBrains editors.

## Installation

Clone this repository to your templates folder:

* Windows: <home>\.<jb-product>\config\templates
* Linux: ~\.<jb-product>\config\templates
* OS X: ~/Library/Preferences/<jb-product>/templates

e.g
```sh
$ git clone https://github.com/kaluzki/jetbrains-live-templates.git ~/.WebIde100/config/templates
```

## Convert xml to markdown
```bash
$ ./console jblt:convert -f md jblt-php-common.xml > docs/jblt-php-common.md
$ ./console jblt:convert -f md jblt-php-iwat.xml > docs/jblt-php-iwat.md
$ ./console jblt:convert -f md jblt-php-member-access.xml > docs/jblt-php-member-access.md

```

## Template Sets

* [PHP: Common](docs/jblt-php-common.md) `jblt-php-common.xml`
* [PHP: iwat](docs/jblt-php-iwat.md) `jblt-php-iwat.xml`
* [PHP: Member access](docs/jblt-php-member-access.md) `jblt-php-member-access.xml`