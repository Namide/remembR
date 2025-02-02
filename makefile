SHELL = /bin/sh

USER_ID := $(shell id -u)
GROUP_ID := $(shell id -g)

export USER_ID
export GROUP_ID

dev:
	docker compose -f ./conf/compose.yml down
	docker compose -f ./conf/compose.yml up