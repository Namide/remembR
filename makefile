SHELL = /bin/sh

USER_ID := $(shell id -u)
GROUP_ID := $(shell id -g)

export USER_ID
export GROUP_ID

dev:
	docker compose -f ./conf/compose.yml down
	docker compose -f ./conf/compose.yml up

code:
	docker run -ti --rm \
		-v $(shell pwd)\:/usr/src/app \
		-w /usr/src/app/blocks \
		-p 8080\:5173 \
		-p 8888\:8888 \
		-u "node" \
		-e NPM_CONFIG_PREFIX=/home/node/.npm-global \
		node:slim \
		bash

build:
	docker run -ti --rm \
		-v $(shell pwd)\:/usr/src/app \
		-w /usr/src/app/blocks \
		-u "node" \
		-e NPM_CONFIG_PREFIX=/home/node/.npm-global \
		node:slim \
		bash -c "npm i; npm run build"

cli:
	docker run -ti --rm \
		-v $(shell pwd)\:/usr/src/app \
		-w /usr/src/app/wp/wp-content/plugins/remembr \
		codeccoop/wp-cli \
		bash