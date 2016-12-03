# EstimationSuite-API
This project is a REST API developed using Laravel. 

##GET
GET
/api/projects/<br>
Submitting a GET request to the resource above returns a json array containing a list of all projects in the database.
For example purposes I omitted the actual json array because it would be too long.
```json
[
 {},
 {},
 {}
]
```

GET
/api/projects/{id}<br>
Submitting a request to the resource with a given project Id returns the project,
the list of sets it's associated with, and the list of parts each project set is associated with
```json
{
  "id": 1,
  "name": "az7QiMCg5ws9KZxFpnQ8M5puj",
  "created_at": "2016-08-01 04:48:23",
  "updated_at": "2016-08-01 04:48:23",
  "sets": [
    {
      "id": 34,
      "name": "RlHD8KR21Z5JCXm9212YvBjWS",
      "created_at": "2016-08-01 04:48:24",
      "updated_at": "2016-08-01 04:48:24",
      "parts": [
        {
          "id": 4,
          "name": "c2Qb6BXT39oO0s4lxxE3BLhAo",
          "weight": 45.26,
          "units": 46,
          "stock": 5,
          "length": 30.1,
          "width": 32.37,
          "sales_price": 4.4,
          "purchase_price": 20.27,
          "created_at": 1470026904,
          "updated_at": 1470026904
        },
        {
          "id": 42,
          "name": "7oxKX6l0ob4D9CfogfpMGCpwP",
          "weight": 37.23,
          "units": 39,
          "stock": 45,
          "length": 42.46,
          "width": 5.48,
          "sales_price": 41.41,
          "purchase_price": 32.24,
          "created_at": 1470026904,
          "updated_at": 1470026904
        }
      ],
      "pivot": {
        "project_id": 1,
        "set_id": 34,
        "id": 48
      }
    }
  ]
}
```

GET
/api/projects/search/{name}<br>
This resource above allows the consumer to search for all products by a name


POST
/api/projects/<br>
To create a new project sending a POST request to this resource with the post body
```text
name=New+fancy+project
```

If successful it returns
```json
{"name":"New fancy project","updated_at":"2016-12-03 02:47:19","created_at":"2016-12-03 02:47:19","id":51}
```

##Put
PUT
/api/projects/{id}

To edit an existing project, submitting a PUT request to this URL with the post body

```text
name=Demo+4+GitHub
```

If successful it returns
```json
{"id":51,"name":"Demo 4 GitHub","created_at":"2016-12-03 02:47:19","updated_at":"2016-12-03 02:50:11"}
```

##Delete
DELETE
/api/projects/{id}<br>
Submitting a DELETE request to the resource above with a given project Id deletes that specific project from the database.

```json
{"msg":"Item 51 successfully deleted"}
```
<hr>

##Other resources
This same REST principals also applies to the resources _/api/sets_ and _/api/parts_. 
The only difference is that, when sending a GET request to  _/api/sets_/{id} or  _/api/parts_/{id}, they do not return a list of all projects they are associated with.
An example is as shown below.

/api/sets/1
```json
{
  "id": 1,
  "name": "xrf4BbqCUyTlIMwu5V1dZsnVD",
  "created_at": "2016-08-01 04:48:24",
  "updated_at": "2016-08-01 04:48:24"
}
```

/api/parts/1
```json
{
  "id": 1,
  "name": "HmJ2ZpQwj2RTn3Y4JVR0zCG5S",
  "weight": 5.32,
  "units": 30,
  "stock": 14,
  "length": 15.49,
  "width": 46.19,
  "sales_price": 6.28,
  "purchase_price": 50.31,
  "created_at": "2016-08-01 04:48:24",
  "updated_at": "2016-08-01 04:48:24"
}
```

<hr>

##Reports
GET
reports/project/{id}<br>
The final stage of this web panel is to produce a report for a specified project.
<br>Submitting a GET request to the resource above will then generate a report for the end user(my client).
<img src="http://i.imgur.com/2CaA0yr.png">

<hr>

##ERD
<img src="http://i.imgur.com/O0JfNSa.png">