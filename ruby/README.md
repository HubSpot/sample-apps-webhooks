# HubSpot-ruby sample Webhooks app

### Note on the Data Base
This application uses MySQL database to store the events coming from Webhooks. There is a single events table:
```
create table if not exists events
(
    id              INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    event_type      VARCHAR(255),
    object_id       int             default null,
    event_id        bigint          default null,
    occurred_at     bigint          default null,
    property_name   varchar(255)    default null,
    property_value  varchar(255)    default null,
    created_at      datetime        default CURRENT_TIMESTAMP
);
```
Please note that event_id sent by HubSpot needs to be stored as int

### Setup App

Make sure you have [Docker Compose](https://docs.docker.com/compose/) installed.

### Configure

1. Copy .env.template to .env
2. Paste your HUBSPOT_CLIENT_ID, HUBSPOT_CLIENT_SECRET, HUBSPOT_APPLICATION_ID and HUBSPOT_DEVELOPER_API_KEY

### Running

The best way to run this project (with the least configuration), is using docker compose.  Change to the webroot and start it

```bash
docker-compose up --build
```

Copy Ngrok url from console. Now you should now be able to navigate to that url and use the application.

### NOTE about Ngrok Too Many Connections error

If you are using Ngrok free plan and testing the application with large amount of import/deletions of Contacts you are likely to see Ngrok "Too Many Connections" error.
This is caused by a large amount of weebhooks events being sent to Ngrok tunnel. To avoid it you can deploy sample applications on your server w/o Ngrok or upgrade to Ngrok Enterprise version

### HubSpot Signature
To help improve security, HubSpot webhooks are sent with signature so you can verify that it came from HubSpot. This sample application shows how to do that verification. You can read more about validation in general here: https://developers.hubspot.com/docs/api/webhooks/validating-requests.
The source code for validating webhooks is at [an usage example](./src/routes/webhooks.py).

### Process with the app

1. Authorize your app with Hubpost OAuth (Press "Authorize" button).
2. Subscribe to Hubspot Webhooks (Press "Start" button).
3. Create some Hubspot Contacts. You can use this [Sample App](https://github.com/HubSpot/sample-apps-manage-crm-objects) to do so.

```
ruby cli.rb -m create -t contact -p '{"email":"brianhalligan@email.com","firstname":"Brian","lastname":"Halligan"}'
```

4. Reload /events page to check recieved updated.
