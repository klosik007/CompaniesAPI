# CompaniesAPI
## Setup
On local environment:
- fetch repo
- type composer update and composer install in repo terminal
- make sure your local instance of database has user root on port 3306 with url 127.0.0.1
- make database migrations: php bin/console make:migration and php bin/console doctrine:migrations:migrate
- start tests (on my environment have worked)
## Endpoints
Company:
- GET /company/all - list all companies from database
- GET /company/{id} - show company details by company id
- POST /company - create company entity in database, provide JSON like this (all data in JSON are required.):
```json
{
  "name": "nowa nazwa",
  "address": "Nowa Huta22",
  "postal": "76-200",
  "NIP": "9876543210"
}
```
- PATCH /company/{id} - update company data by company id, provide needed data to update in JSON as well
- DELETE /company/{id} - delete company data by company id

Employee:
- GET /employee/all - list all employees from database
- GET /employee/{id} - show employee details by employee id
- POST /employee - create employee entity in database, provide JSON like this (all data in JSON are required except phone):
```json
{
  "name": "Kłos",
  "surname": "Janek",
  "email": "pklos1992@gmail.com",
  "phone": "512655101",
  "company_id": 1
}
```
- PATCH /employee/{id} - update employee data by employee id and/or companyId_employeeId relationship, provide needed data to update in JSON as well
- DELETE /employee/{id} - delete company data by employee id and delete companyId_employeeId relationship if so

 