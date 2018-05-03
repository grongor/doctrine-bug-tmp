Doctrine relations bug example
==============================

When you want to select an entity with its collection of related entities, then the relation's between those two
entities can't be changed for some reason.

In `./src` directory there are both the not working example and the working one, with their output in .txt files
for your convenience. There is also a diff of them to quickly see what "causes this."

You can run the examples yourself:
```
docker-compose up -d
docker-compose run --rm php-cli composer install

docker-compose run --rm php-cli php src/testNotWorking.php
docker-compose run --rm php-cli php src/testWorking.php
```
