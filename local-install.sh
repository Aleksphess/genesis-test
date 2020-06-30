#!/bin/bash

docker exec -it web sh -c "composer config --global --auth github-oauth.github.com 5c8a68c88bd691d1c955511a02d23a742a792086"

docker exec -it web sh -c "composer install --no-interaction"

docker exec -it web sh -c "cp .env.dist .env"

docker exec -it web sh -c "cd console && php yii migrate --interactive=0"
