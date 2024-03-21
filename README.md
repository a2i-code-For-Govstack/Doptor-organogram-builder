# ORGANOGRAM BUILDER DPG

This guide provides step-by-step instructions for installing the PHP application. Please follow the instructions below to get started.

## Authors

- [@Mahmud S.](https://www.linkedin.com/in/mahmud-s-raju)
- [@Tappware Solutions Limited]()

## Prerequisites

Before proceeding with the installation, make sure you have the following software installed on your system:

- PHP (version 7.4 or higher)
- MySql (version 5.6 or higher)
- Composer

## Installation Steps

1. Clone the repository:

   ```shell
   git clone <repository_url>
   ```
2. Change to the organogram-builder-dpg directory:

   ```shell
   cd organogram-builder-dpg
   ```
3. Create a copy of the .env.example file and name it .env:

   ```shell
   cp .env.example .env
   ```
   
4. Edit the ```.env``` file and set the database credentials:

   ```shell
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=oragnogram_builder_db
    DB_USERNAME=root
    DB_PASSWORD=
   ```
5. Import database (find DB in database folder)

6. Edit the ```.env``` file and set the e-mail gateway credentials:

   ```shell
    MAIL_HOST=
    MAIL_PORT=
    MAIL_USERNAME=
    MAIL_PASSWORD=
    MAIL_ENCRYPTION=
    MAIL_FROM_ADDRESS=
    ```
   
7. Edit the ```.env``` file and set the sms gateway credentials:

   ```shell
    SMS_GATEWAY_URL=
    SMS_GATEWAY_USER=
    SMS_GATEWAY_PASS=
    SMS_GATEWAY_A_CODE=
    SMS_GATEWAY_MASKING=
    ```
8. Edit the ```.env``` file and set the queue driver:

   ```shell
   QUEUE_CONNECTION=database
    ```
   
8. Install the required dependencies using Composer:

   ```shell
   composer install
   ```
9. Run the following command in the terminal:

   ```shell
   php artisan key:generate
   ```
   ```shell
   php artisan storage:link
   ```
10. Run the following command in the terminal:

    ```shell
    chmod -R 777 storage bootstrap/cache
    ```
    
11. Install ```supervisor``` and configure the following command.
    ```shell
    php artisan queue:work
    ```
### Default Users

Login as an Admin

Username: admin

Password: 12345678

## Licensing
Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.


## Thank You

We appreciate your support and hope you find our DOPTOR DATA DPG.

Best regards,

[Tappware Team](https://tappware.com/)
