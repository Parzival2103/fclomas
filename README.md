# Fclomas

This project requires a database connection. Configuration values are loaded from environment variables at runtime.

## Required environment variables

- `DB_HOST` - database host
- `DB_USER` - database user
- `DB_PASSWORD` - database password
- `DB_NAME` - database name

These variables must be available to PHP before using any scripts that access the database.

The repository includes a `.env` file with example credentials. You can `source` this file before running any PHP scripts to make the variables available.
