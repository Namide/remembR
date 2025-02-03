# RemembR

Wordpress addon to use [spaced repetition](https://en.wikipedia.org/wiki/Spaced_repetition).

> ⚠️ Under development

## Development

### Local URLs

|            | link                                                       |
| ---------- | ---------------------------------------------------------- |
| frontend   | [localhost:8380](http://localhost:8380/)                   |
| admin      | [localhost:8380/wp-admin](http://localhost:8380/wp-admin/) |
| phpmyadmin | [localhost:8381](http://localhost:8381/)                   |

### Requirements

To run local dev server with a php server, a mysql database, a phpMyAdmin server and a Wordpress image to download all files.
All this configuration is in the `conf/compose.yml` file.

- [Docker](https://docs.docker.com/engine/install/)
- [Make](https://www.gnu.org/software/make/)

### How it works?

Makefile use Docker to run all servers in localhost.
For Windows you can use wsl2 to run Docker and make commands.

### Commands

```bash
# Run the local dev server (sql, apache and phpmyadmin)
make dev

# Visit http://localhost:8380/
```
