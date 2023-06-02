console-in:
	docker-compose exec unigine_test_php bash

update_is-expired:
	docker-compose exec unigine_test_php php ./url-shortener.loc/bin/console cli:update-is-expired-status
