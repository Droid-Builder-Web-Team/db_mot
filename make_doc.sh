#!/bin/bash

# Generate phploc
phploc --log-xml=build/phploc.xml app

# PHP CS
phpcs app --report-xml=build/phpcs.xml

# And finally, phpdox
/usr/share/php/TheSeer/phpDox/phpdox

