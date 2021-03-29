## Initial evaluation
Languages endpoint:
```json
GET /languages
[
    {
        "name": "English",
        "isoCode": "en",
        "rtl": false,
        "id": 1
    },
    {
        "name": "Latvian",
        "isoCode": "lv",
        "rtl": false,
        "id": 2
    },
    {
        "name": "Belarusian",
        "isoCode": "be",
        "rtl": false,
        "id": 3
    },
    {
        "name": "Russian",
        "isoCode": "ru",
        "rtl": false,
        "id": 4
    },
    {
        "name": "Arabic",
        "isoCode": "ar",
        "rtl": true,
        "id": 5
    }
]
```
Translation key endpoints:
```json
GET /translation-keys
[
    {
        "name": "index.welcome",
        "id": 1,
        "createdAt": "2021-03-28T17:56:47+03:00",
        "updatedAt": "2021-03-28T17:56:47+03:00"
    },
    {
        "name": "index.contacts",
        "id": 2,
        "createdAt": "2021-03-28T18:08:00+03:00",
        "updatedAt": "2021-03-28T18:39:26+03:00"
    }
]

POST /translation-keys
{
	"name": "index.subscribe"
}
{
    "name": "index.subscribe",
    "id": 11,
    "createdAt": "2021-03-29T16:22:41+03:00",
    "updatedAt": "2021-03-29T16:22:41+03:00"
}

GET /translation-keys/{id}
{
    "name": "index.subscribe",
    "id": 11,
    "createdAt": "2021-03-29T16:22:41+03:00",
    "updatedAt": "2021-03-29T16:22:41+03:00"
}

PUT /translation-keys/{id}
{
    "name": "index.unsubscribe"
}
{
    "name": "index.unsubscribe",
    "id": 11,
    "createdAt": "2021-03-29T16:22:41+03:00",
    "updatedAt": "2021-03-29T16:24:23+03:00"
}

DELETE /translation-keys/{id}
```
Translation endpoints:
```json
GET /translations
[
    {
        "translationKey": {
            "name": "index.welcome",
            "id": 1
        },
        "language": {
            "name": "English",
            "isoCode": "en",
            "rtl": false,
            "id": 1
        },
        "value": "Welcome",
        "id": 1,
        "createdAt": "2021-03-28T21:05:53+03:00",
        "updatedAt": "2021-03-28T21:05:53+03:00"
    }
]

POST /translations
{
	"translationKey": 7,
	"language": 1,
	"value": "News"
}
{
    "translationKey": {
        "name": "index.news",
        "id": 7,
        "createdAt": "2021-03-28T21:05:53+03:00",
        "updatedAt": "2021-03-28T21:05:53+03:00"
    },
    "language": {
        "name": "English",
        "isoCode": "en",
        "rtl": false,
        "id": 1
    },
    "value": "News",
    "id": 5,
    "createdAt": "2021-03-29T16:36:34+03:00",
    "updatedAt": "2021-03-29T16:36:34+03:00"
}
```
Update translation manually:
```json
PUT /translations/{id}
{
	"translationKey": 2,
	"language": 1,
	"value": "Contacts"
}
{
    "translationKey": {
        "name": "contacts",
        "id": 2,
        "createdAt": "2021-03-28T18:08:00+03:00",
        "updatedAt": "2021-03-29T16:27:06+03:00",
        "__isInitialized__": true
    },
    "language": {
        "name": "English",
        "isoCode": "en",
        "rtl": false,
        "id": 1,
        "__isInitialized__": true
    },
    "value": "Contacts",
    "id": 2,
    "createdAt": "2021-03-28T22:25:38+03:00",
    "updatedAt": "2021-03-28T22:43:17+03:00"
}
```
Update using machine translation:
```json
POST /translations/1/machine-translate
{
  "language": 2
}
{
  "translationKey": {
    "name": "index.welcome",
    "id": 1,
    "createdAt": "2021-03-28T17:56:47+03:00",
    "updatedAt": "2021-03-28T17:56:47+03:00"
  },
  "language": {
    "name": "Latvian",
    "isoCode": "lv",
    "rtl": false,
    "id": 2
  },
  "value": "Laipni lūdzam",
  "id": 7,
  "createdAt": "2021-03-29T16:41:48+03:00",
  "updatedAt": "2021-03-29T16:41:48+03:00"
}
```
Zip export:
```
GET /translations/export?format=json
GET /translations/export?format=yaml
```
Examples: [json](translations-json-20210329164907.zip) [yaml](translations-yaml-20210329164858.zip)
