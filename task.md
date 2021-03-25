Design and implement an API for an app that manages keys and their translations. 

## Acceptance criteria
 

### API should provide this functionality:
- API token authentication
- List available languages
- Manage keys
    - List
    - Retrieve
    - Create
    - Rename
    - Delete
- Manage translations
    - Update values
    - Update using machine translation (any translation can be used as a source and other language can be a target)
        - Google Cloud Translation API should be used
            - [TranslateClient by Google](https://googleapis.github.io/google-cloud-php/#/docs/google-cloud/v0.142.0/translate/v2/translateclient)
            - [Basics](https://cloud.google.com/translate/docs/basic/translating-text)
            - Credentails are provided in `keyfile.json`
            - Supported languages ([Link 1](https://cloud.google.com/translate/docs/languages), [Link 2](https://cloud.google.com/translate/docs/basic/discovering-supported-languages))
    - Manual update & machine translation updates should be handled by different endpoints
        
- Export translations in zip (separately for each format)
    - In .json format with 1 file per language ([language-iso].json)
        - format: {key.name: translation.value, ...}
    - In .yaml with all languages in 1 file (translations.yaml). All keys should be listed under specific language.
        - format & hierarchy: language.iso -> key.name -> translation.value 
 

###  Languages should:
- Have a name
- Have an ISO code
- Have Right To Left (RTL) flag
- Be generated using DB migration or any other similar method (5 languages will be enough, with at least 1 RTL language)
 

### Key should:
- Have a unique name
- Be identified by ID trough API (not name)
- Have one translation per language at all times


### Translation should have:
- A value
- An associated key (referred using ID)
- An associated language (reffered using ISO code)


### API Tokens should:
- Be stored in the database
- Be unique
- Be one of 2 types (read-only, read-write)
- Be generated using DB migration or any other similar method (1 read-only and 1 read-write will be enough)


### You can:
- Use any PHP framework you are comfortable with


### You have to demonstrate in an HTTP client of your choice:
- How the authentication works
- How languages are listed
- How keys are created, listed, renamed and deleted 
- How multiple keys with the same name cannot be created
- How translations are updated
- How translations are updated using Machine Translation
- How export works for both formats

## Initial evaluation
To improve the speed of inital evaluation please provide request examples with responses. If can provide examples with more details if you want to.
```
GET /items

{
 "items": []
}

POST /items

{
 "name": "value"
}

{
 "response": "object"
}
```
