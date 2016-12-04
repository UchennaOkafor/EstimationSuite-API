# EstimationSuite-API
This project is a REST API developed using Laravel. This API compliments the client side C# application I developed.
<br>Below, is the link to the complimentary project
https://github.com/uche1/EstimationSuite/

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
  "id": 14,
  "name": "Project 14",
  "created_at": "2016-12-04 01:28:10",
  "updated_at": "2016-12-04 01:28:10",
  "sets": [
    {
      "id": 1,
      "name": "Set 1",
      "created_at": "2016-12-04 01:28:10",
      "updated_at": "2016-12-04 01:28:10",
      "parts": [],
      "pivot": {
        "project_id": 14,
        "set_id": 1,
        "id": 24
      }
    },
    {
      "id": 9,
      "name": "Set 9",
      "created_at": "2016-12-04 01:28:10",
      "updated_at": "2016-12-04 01:28:10",
      "parts": [],
      "pivot": {
        "project_id": 14,
        "set_id": 9,
        "id": 1
      }
    },
    {
      "id": 11,
      "name": "Set 11",
      "created_at": "2016-12-04 01:28:10",
      "updated_at": "2016-12-04 01:28:10",
      "parts": [
        {
          "id": 24,
          "name": "Part 24",
          "weight": 39.2,
          "units": 40,
          "stock": 34,
          "length": 5.16,
          "width": 17.32,
          "sales_price": 8.48,
          "purchase_price": 9.43,
          "created_at": 1480814891,
          "updated_at": 1480814891
        }
      ],
      "pivot": {
        "project_id": 14,
        "set_id": 11,
        "id": 50
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
name=New fancy project
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
name=Demo 4 GitHub
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
  "name": "Set 1",
  "created_at": "2016-12-04 01:28:10",
  "updated_at": "2016-12-04 01:28:10"
}
```

/api/parts/1
```json
{
  "id": 1,
  "name": "Part 1",
  "weight": 35.48,
  "units": 16,
  "stock": 17,
  "length": 30.16,
  "width": 7.15,
  "sales_price": 47.6,
  "purchase_price": 16.11,
  "created_at": "2016-12-04 01:28:10",
  "updated_at": "2016-12-04 01:28:10"
}
```

POST
projects/project_set/<br>
Sending a POST request with the body
```text
project_id=13&set_ids=[28,29,34]
```
Will create a projectSet association for each set Id in the given array

DELETE
projects/project_set/{projectSetId}<br>
Sending a post request to this URL with the projectSetId deletes the given projectSet association

####More
For full details of the other REST resources for this project please visit the app/Http/routes.php file.

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

##Disclaimer
This project was written by me in 2016 during summer for a client who wishes to remain anonymous.
Therefore, this repository is only to showcase my work. I give no permission for anyone to use this project or any part of it in any shape or form.
Hence the omission of a license.