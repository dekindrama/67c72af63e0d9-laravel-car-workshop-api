# **Simple Car Workshop System **

---

> simple car workshop system that has been build using Laravel 11, MySql and any other pakages. It containing basic token auth, Rest Api & more.

---

### **project features**

---

admin can :

mechanic, can :

customer, can :

### **installation**

---

clone the repository

```
git clone https://github.com/dekindrama/67c72af63e0d9-laravel-car-workshop-api.git
```

switch to the folder project

```
cd 67c72af63e0d9-laravel-car-workshop-api
```

install all the dependencies

```
composer install
npm install
```

copy .example.env file and make the required configuration changes in the .env file

```
cp .env.example .env
```

setup database on .env file

```
DB_DATABASE=test
```

setup SMTP Provider on .env file (**note:** example down below is has not been set yet, you need to set it up by yourself. You can use [Mailtrap](https://mailtrap.io/) for SMTP Provider)

```
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"
```

generate new application key

```
php artisan key:generate
```

run the database migrations & seeder (**attention:** make sure you already have database **test** on your MySql before run the migrations)

```
php artisan migrate:fresh --seed
```

start local development server

```
php artisan serve
```

after doing the steps, you now be able to access the api.

---

### **System Design**

---

Entity Relationship Diagram
![image](/documentations/ERD-ERD.jpg)

---

---

### **Testing**

---

### Manual Testing

---

for manually testing the api, you can use [Postman](https://www.postman.com/downloads/).

here is the link of collection that i used to manual testing the api. you can open it on your browser and import it to your Postman App

```
[postman link]
```

---

### Automatic Testing

---

for automatic testing the api, you can type _php artisan test_ on your terminal

```
php artisan test
```

---
