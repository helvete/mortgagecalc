#!/usr/bin/make -f

.PHONY: run
run: date
	docker-compose up --build --force-recreate -d

.PHONY: stop
stop:
	docker-compose down

.PHONY: logs
logs:
	docker-compose logs -f

.PHONY: date
date:
	@date
