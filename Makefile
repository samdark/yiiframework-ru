CLI_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
$(eval $(sort $(subst :,\:,$(CLI_ARGS))):;@:)

PRIMARY_GOAL := $(firstword $(MAKECMDGOALS))
ifeq ($(PRIMARY_GOAL),)
    PRIMARY_GOAL := help
endif

include docker/.env

# Current user ID and group ID except MacOS where it conflicts with Docker abilities
ifeq ($(shell uname), Darwin)
    export UID=1000
    export GID=1000
else
    export UID=$(shell id -u)
    export GID=$(shell id -g)
endif

DOCKER_COMPOSE_DEV := COMPOSE_PROJECT_NAME=${STACK_NAME}-dev docker compose -f docker/compose.yml -f docker/dev/compose.yml
DOCKER_RUN_DEV_APP := $(DOCKER_COMPOSE_DEV) run --rm --user $(UID):$(GID) app
DOCKER_RUN_DEV_ROOT := $(DOCKER_COMPOSE_DEV) run --rm app
PROD_ENV_FILES := --env-file docker/.env
ifneq ($(wildcard docker/prod/override.env),)
    PROD_ENV_FILES += --env-file docker/prod/override.env
endif
DOCKER_COMPOSE_PROD := COMPOSE_PROJECT_NAME=${STACK_NAME}-prod docker compose $(PROD_ENV_FILES) -f docker/compose.yml -f docker/prod/compose.yml

#
# Development
#

ifeq ($(PRIMARY_GOAL),build)
build: ## Build docker images.
	$(DOCKER_COMPOSE_DEV) build $(CLI_ARGS)
endif

ifeq ($(PRIMARY_GOAL),up)
up: ## Up the dev environment.
	@DOCKER_COMPOSE_DEV='$(DOCKER_COMPOSE_DEV)' ./docker/dev/up.sh
endif

ifeq ($(PRIMARY_GOAL),open)
open: ## Open the running app in the default browser.
	@DOCKER_COMPOSE_DEV='$(DOCKER_COMPOSE_DEV)' ./docker/dev/open.sh
endif

ifeq ($(PRIMARY_GOAL),down)
down: ## Down the dev environment.
	$(DOCKER_COMPOSE_DEV) down --remove-orphans
endif

ifeq ($(PRIMARY_GOAL),stop)
stop: ## Stop the dev environment.
	$(DOCKER_COMPOSE_DEV) stop
endif

ifeq ($(PRIMARY_GOAL),clear)
clear: ## Remove development docker containers and volumes.
	$(DOCKER_COMPOSE_DEV) down --volumes --remove-orphans
endif

ifeq ($(PRIMARY_GOAL),shell)
shell: ## Get into container shell.
	$(DOCKER_COMPOSE_DEV) exec app /bin/bash
endif

ifeq ($(PRIMARY_GOAL),restart)
restart: ## Restart the dev environment.
	$(DOCKER_COMPOSE_DEV) restart
endif

ifeq ($(PRIMARY_GOAL),bootstrap)
bootstrap: ## Bootstrap app (install + init + migrate).
	$(DOCKER_RUN_DEV_APP) composer install --no-interaction
	$(DOCKER_RUN_DEV_APP) sh -c "cd vendor && ln -sf bower-asset bower 2>/dev/null || true"
	$(DOCKER_RUN_DEV_ROOT) sh -lc "mkdir -p /app/runtime/rbac /app/runtime /app/www/assets && rm -f /app/runtime/rbac/items.php /app/runtime/rbac/assignments.php /app/runtime/rbac/rules.php && chown -R $(UID):$(GID) /app/runtime /app/www/assets && chmod -R u+rwX,g+rwX /app/runtime /app/www/assets"
	$(DOCKER_RUN_DEV_APP) php ./init --env=Development --overwrite=No
	$(DOCKER_RUN_DEV_APP) ./yii migrate --interactive=0
.PHONY: bootstrap
endif

ifeq ($(PRIMARY_GOAL),setup)
setup: ## Setup dev environment and bootstrap app.
	$(DOCKER_COMPOSE_DEV) up -d --wait --remove-orphans
	$(MAKE) bootstrap
.PHONY: setup
endif

#
# Tools
#

ifeq ($(PRIMARY_GOAL),yii)
yii: ## Execute Yii command.
	$(DOCKER_RUN_DEV_APP) ./yii $(CLI_ARGS)
.PHONY: yii
endif

ifeq ($(PRIMARY_GOAL),composer)
composer: ## Run Composer.
	$(DOCKER_RUN_DEV_APP) composer $(CLI_ARGS)
	$(DOCKER_RUN_DEV_APP) sh -c "cd vendor && ln -sf bower-asset bower 2>/dev/null || true"
endif

ifeq ($(PRIMARY_GOAL),php)
php: ## Run PHP.
	$(DOCKER_RUN_DEV_APP) php $(CLI_ARGS)
endif

ifeq ($(PRIMARY_GOAL),init)
init: ## Initialize environment (copy configs from environments).
	$(DOCKER_RUN_DEV_APP) php ./init --env=Development --overwrite=No
.PHONY: init
endif

ifeq ($(PRIMARY_GOAL),migrate)
migrate: ## Run migrations.
	$(DOCKER_RUN_DEV_ROOT) sh -lc "mkdir -p /app/runtime/rbac /app/runtime /app/www/assets && rm -f /app/runtime/rbac/items.php /app/runtime/rbac/assignments.php /app/runtime/rbac/rules.php && chown -R $(UID):$(GID) /app/runtime /app/www/assets && chmod -R u+rwX,g+rwX /app/runtime /app/www/assets"
	$(DOCKER_RUN_DEV_APP) ./yii migrate $(CLI_ARGS)
.PHONY: migrate
endif

#
# Production
#

ifeq ($(PRIMARY_GOAL),prod-up)
prod-up: ## Up the production-like environment.
	@if [ ! -f docker/prod/override.env ] || ! grep -Eq '^ROLLBAR_ACCESS_TOKEN=.+$$' docker/prod/override.env; then echo "Warning: ROLLBAR_ACCESS_TOKEN is not set in docker/prod/override.env. Rollbar will be disabled for this production-like run."; fi
	$(DOCKER_COMPOSE_PROD) up -d --build --wait --remove-orphans
	$(DOCKER_COMPOSE_PROD) exec app ./yii migrate --interactive=0
endif

ifeq ($(PRIMARY_GOAL),prod-down)
prod-down: ## Down the production-like environment.
	$(DOCKER_COMPOSE_PROD) down --remove-orphans
endif

ifeq ($(PRIMARY_GOAL),prod-stop)
prod-stop: ## Stop the production-like environment.
	$(DOCKER_COMPOSE_PROD) stop
endif

ifeq ($(PRIMARY_GOAL),prod-restart)
prod-restart: ## Restart the production-like environment.
	$(DOCKER_COMPOSE_PROD) restart
endif

ifeq ($(PRIMARY_GOAL),prod-logs)
prod-logs: ## Show production-like environment logs.
	$(DOCKER_COMPOSE_PROD) logs $(CLI_ARGS)
.PHONY: prod-logs
endif

ifeq ($(PRIMARY_GOAL),prod-shell)
prod-shell: ## Get into production app container shell.
	$(DOCKER_COMPOSE_PROD) exec app /bin/bash
endif

ifeq ($(PRIMARY_GOAL),prod-migrate)
prod-migrate: ## Run migrations in production-like environment.
	$(DOCKER_COMPOSE_PROD) exec app ./yii migrate $(CLI_ARGS)
.PHONY: prod-migrate
endif

ifeq ($(PRIMARY_GOAL),prod-build)
prod-build: ## Build an image.
	docker build --file docker/Dockerfile --target prod --pull -t ${IMAGE}:${IMAGE_TAG} .
endif

ifeq ($(PRIMARY_GOAL),prod-push)
prod-push: ## Push image to repository.
	docker push ${IMAGE}:${IMAGE_TAG}
endif

#
# Help
#

ifeq ($(PRIMARY_GOAL),help)
help: ## Show this help.
	@echo "Usage: make [target]"
	@echo ""
	@echo "Development:"
	@echo "  build        Build docker images"
	@echo "  up           Up the dev environment"
	@echo "  open         Open the running app in browser"
	@echo "  down         Down the dev environment"
	@echo "  stop         Stop the dev environment"
	@echo "  restart      Restart the dev environment"
	@echo "  clear        Remove development docker containers and volumes"
	@echo "  shell        Get into container shell"
	@echo "  bootstrap    Bootstrap app (install + init + migrate)"
	@echo "  setup        Setup dev environment and bootstrap app"
	@echo ""
	@echo "Tools:"
	@echo "  yii          Execute Yii command (pass args after target)"
	@echo "  composer     Run Composer (pass args after target)"
	@echo "  php          Run PHP (pass args after target)"
	@echo "  migrate      Run migrations (pass args after target)"
	@echo ""
	@echo "Production:"
	@echo "  prod-up      Up the production-like environment"
	@echo "  prod-down    Down the production-like environment"
	@echo "  prod-stop    Stop the production-like environment"
	@echo "  prod-restart Restart the production-like environment"
	@echo "  prod-logs    Show production-like environment logs"
	@echo "  prod-shell   Get into production app container shell"
	@echo "  prod-migrate Run migrations in production-like environment"
	@echo "  prod-build   Build production image"
	@echo "  prod-push    Push production image to repository"
	@echo ""
	@echo "Help:"
	@echo "  help         Show this help"
endif
