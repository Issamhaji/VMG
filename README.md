
# Project Name
# VMG

This is a brief description of your project.

## Installation and Setup

Follow these steps to set up the project:

### Step 1: Clone and Install Dependencies

```bash
# Clone the project
git clone https://github.com/your-username/your-repo.git

# Change to the project directory root
cd your-repo

# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```
### Step 2: Configure your environment variables 

For MySQL: this my env.local 

DATABASE_URL="mysql://root:@127.0.0.1:3306/vmg"

### Step 3: Set Up the Database

```bash
# create database
php bin/console doctrine:database:create

# perform migrations
php bin/console doctrine:migrations:migrate

# load data
php bin/console doctrine:fixtures:load

```

### Step 4: Start the Project
```bash
# start project
symfony server:start -d

#build
npm run watch
```


