668  /usr/share/php/TheSeer/phpDox/phpdox
  669  apt-cache search phploc
  670  sudo apt-get install phploc
  671  /usr/share/php/TheSeer/phpDox/phpdox
  672  grep -i phploc *
  673  vi phpdox.xml 
  674  /usr/share/php/TheSeer/phpDox/phpdox
  675  vi phpdox.xml 
  676  ls -lart
  677  phploc
  678  phploc --log-xml=test
  679  phploc --log-xml=test.xml
  680  phploc --log-xml=test.xml app
  681  cat test.xml 
  682  phploc --log-xml=build/phploc.xml app
  683  /usr/share/php/TheSeer/phpDox/phpdox
  684  phpcs
  685  phpcs --help
  686  phpcs app
  687  /usr/share/php/TheSeer/phpDox/phpdox
  688  phpcs --help
  689  phpcs app --report-xml=build/logs/phpcs.xml
  690  phpcs app --report-xml=build/phpcs.xml
  691  vi phpdox.xml 
  692  /usr/share/php/TheSeer/phpDox/phpdox
  693  phpcs app --report-xml=build/phpcs.xml
  694  ls build/
  695  vi phpdox.xml 
  696  phpcs app --report-xml=build/phpcs.xml
  697  /usr/share/php/TheSeer/phpDox/phpdox
#!/bin/bash

# Generate phploc
phploc --log-xml=build/phploc.xml app

# PHP CS
phpcs app --report-xml=build/phpcs.xml

# And finally, phpdox
/usr/share/php/TheSeer/phpDox/phpdox

