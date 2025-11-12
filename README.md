# CBBB - Affiliate nástroj

## Stack

### Backend

| Technology        | Version | Description                    | Useful links                                                         |
|-------------------|:-------:|--------------------------------|----------------------------------------------------------------------|
| PHP               | 8.0.3   | Scripting Language             | [Homepage](https://www.php.net/)                                         |
| Composer          | 2.1.6   | PHP Package Manager            | [Homepage](https://getcomposer.org/), [Packages](https://packagist.org/) |
| Nette             | 3.1     | PHP Framework                  | [Homepage](https://nette.org/)                                           |
| Doctrine/ORM      | 2.9.5   | PHP Library / Composer Package | [Homepage](https://www.doctrine-project.org/)                            |
| Symfony/Console   | 5.3.7   | PHP Library / Composer Package | [Homepage](https://symfony.com/doc/5.3/components/console.html)          |
| MariaDB           | 10.6.4  | MySQL Relation Database        | [Homepage](https://mariadb.org/)                                         |

### Frontend

| Technology        | Version | Description                    | Useful links                                                         |
|-------------------|:-------:|--------------------------------|----------------------------------------------------------------------|
| Node              | 16.9.1  | JavaScript runtime             | [Homepage](https://nodejs.org/)                                      |
| NPM               | 7.21.1  | Node Package Manager           | [Homepage](https://www.npmjs.com/)                                   |
| Webpack           | 5.52.1  | Module bundler                 | [Homepage](https://webpack.js.org/)                                  |
| Sass              | 1.41.0  | CSS extension language         | [Homepage](https://sass-lang.com/)                                   |


### DevOps, QA & Tools

| Technology        | Version | Description                    | Useful links                                                         |
|-------------------|:-------:|--------------------------------|----------------------------------------------------------------------|
| Gitlab CI         |         |                                |                                                                      |
| Docker            |         |                                |                                                                      |
| PHP Code Sniffer  |         |                                |                                                                      |
| PHPStan           |         |                                |                                                                      |
| PHPUnit           |         |                                |                                                                      |

### Make Targets

| Targets           | Description                                                                                                    |
|-------------------|----------------------------------------------------------------------------------------------------------------|
| up                | Nahodí projekt                                                                                                 |
| up\:build         | Nahodí projekt                                                                                                 |
| down              | Stopne projekt                                                                                                 |
| logs              | Zobrazí logy                                                                                                   |
| exec\:php         | Spustí php container                                                                                           |
| init              | Init project                                                                                                   |
| **Database**      |                                                                                                                |
| db-drob           | Smaže DB                                                                                                       |
| db-create         | Vytvoří DB                                                                                                     |
| db-load           | Nahraje obsah                                                                                                  |
| db                | - db-drob <br> - db-create<br>- db-load                                                                        |
| **Quality Code**  |                                                                                                                |
| cs                | Code Sniffer                                                                                                   |
| cs-fix            | Fixuje Code Sniffer                                                                                            |
| phpstan           | PHPSTAN                                                                                                        |
| tests             | Unit testy                                                                                                     |
| code-checker      | Code Checker                                                                                                   |
| code-checker-fix  | Fixuje Code Checker                                                                                            |
| qa                | - cs<br> - fix <br> - phpstan <br> - tests <br> - db-tests <br> - code-checker <br>  - code-checker-fix        |
| **Fix**    |                                                                                                                       |
| fix               | Pokusí se utomaticky opravit chyby v quality code                                                              |
| **FTP Deploy**    |                                                                                                                |
| deploy            | FTP Deployment                                                                                                 |
| deploy-test       | FTP Deployment Test                                                                                            |
