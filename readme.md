<p align="center">Ideraos</p>


## About Ideraos

## /api/save/country
Method: Post

Sample Input
{
	"name": "Nigeria"
}

Sample Response
{
  "status": 1,
  'message' => 'Country saved'
}

/api/save/state
Method: Post

Sample Input
{
	"country_id": 1,
	"name": "Lagos"
}

Sample Response
{
  "status": 1,
  "message": "State saved"
}


/api/save/city
Method: Post

Sample Input
{
	"state_id": 1,
	"name": "Ajah"
}

Sample Response
{
  "status": 1,
  "message": "City saved"
}



/api/list/countries
Method: Get

Sample Response
{
  "status": 1,
  "countries": [
    {
      "id": 1,
      "name": "Nigeria"
    }
  ]
}

/api/list/states
Method: Post

Sample Input
{
	"country_id": 1
}

Sample Response
{
  "status": 1,
  "states": [
    {
      "id": 1,
      "name": "Lagos",
      "country_id": 1
    }
  ]
}

/api/list/cities
Method: Post

Sample Input
{
	"state_id": 1
}

Sample Response
{
  "status": 1,
  "states": [
    {
      "id": 1,
      "name": "Lagos",
      "country_id": 1
    }
  ]
}


/api/find/cities-country
Method: Post

Sample Input
{
	"country": "Nigeria"
}

Sample Response
{
  "status": 1,
  "cities": [
    {
      "id": 1,
      "name": "Ajah",
      "state": "Lagos"
    },
    {
      "id": 2,
      "name": "Ikeja",
      "state": "Lagos"
    }
  ]
}