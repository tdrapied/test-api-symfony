# Install
## 1 - Docker and Task
You can download and install Docker and Docker-compose depending on your platform :

- https://docs.docker.com/install/
- https://docs.docker.com/compose/install/

Install TaskFile:
 ```bash
sh -c "$(curl --location https://taskfile.dev/install.sh)" -- -d
 
## For MacOS only
brew install go-task/tap/go-task
 ```
For more info about TaskFile, visit: https://taskfile.dev/#/installation

## 2 - Install dependencies
You can install project using docker compose commands `build, up.` or by just running the following task command:

 ```bash
task install
 
## list all tasks
task --list
```

## 3 - Let's run it
If all your containers are up and running with(`docker compose ps`) or using task (`task docker:ps`). You should add a `local.api-auth.fr` to your `/etc/hosts` file:
 ```bash
# /etc/hosts
127.0.0.1 local.test-api-symfony.fr
::1 local.test-api-symfony.fr
 ```

## 4 - Check it out
- https://local.test-api-symfony.fr
- Doc: https://local.test-api-symfony.fr/doc