# Переменные
# Указываем ваш конкретный файл конфигурации
DEX = docker exec
DC = docker-compose -f docker-compose.local.yml
PROJECT_NAME = tasktimer

# Названия сервисов (проверьте, чтобы они совпадали с именами в вашем .yml)
PHP_SERVICE = $(PROJECT_NAME)-backend
NODE_SERVICE = $(PROJECT_NAME)-frontend

.DEFAULT_GOAL := help

# Команда для вывода списка всех доступных команд
help: ## Справка
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

# --- Docker ---

up: ## Поднять контейнеры (local)
	$(DC) up -d

down: ## Остановить контейнеры
	$(DC) down

build: ## Собрать/пересобрать контейнеры
	$(DC) build

ps: ## Список запущенных контейнеров
	$(DC) ps

logs: ## Посмотреть логи всех контейнеров
	$(DC) logs -f

# --- Backend (Symfony) ---

composer-install: ## Установить PHP зависимости
	$(DEX) $(PHP_SERVICE) composer install

diff: ## Создать миграцию (разница между Entity и БД)
	$(DEX) $(PHP_SERVICE) php bin/console doctrine:migrations:diff

migrate: ## Применить все миграции
	$(DEX) $(PHP_SERVICE) php bin/console doctrine:migrations:migrate --no-interaction

prev: ## Откатить последнюю миграцию
	$(DEX) $(PHP_SERVICE) php bin/console doctrine:migrations:migrate prev --no-interaction

jwt-keys: ## Сгенерировать JWT ключи
	$(DEX) $(PHP_SERVICE) php bin/console lexik:jwt:generate-keypair --skip-if-exists

cc: ## Очистить кэш Symfony
	$(DEX) $(PHP_SERVICE) php bin/console cache:clear

# --- Frontend (Nuxt) ---

npm-install: ## Установить JS зависимости
	$(DEX) $(NODE_SERVICE) npm install

npm-dev: ## Перезапустить dev-сервер фронтенда
	$(DEX) $(NODE_SERVICE) npm run dev

# --- Полезные связки ---

init: up composer-install npm-install jwt-keys migrate ## Полная инициализация проекта

fix-perms: ## Исправить права доступа (выполнять в WSL)
	sudo chown -R ${USER}:${USER} .
	sudo chmod -R 775 var/cache var/log vendor node_modules