# HubSpot-nodejs webhooks sample app

This is a sample app for the [hubspot-nodejs SDK](https://www.npmjs.com/package/@hubspot/api-client).
Currently, this app focuses on demonstrating the functionality of [Webhooks API](https://developers.hubspot.com/docs/api/webhooks), contact update/creation/deletion in particular.

Please note that the Webhooks events are not sent in chronological order with respect to the creation time. Events might be sent in large numbers, for example when the user imports large number of contacts or deletes a large list of contacts.
The application demonstrates the use of Queues (Kafka in case of this application - see [kafka-helper.js](js/kafka-helper.js)) to process webhooks events.

Common webhook processing practice consists of few steps:
1. Handle methods receive the request sent by the webook and immediately place payload on the queue [webhooks-controller.js](js/webhooks-controller.js)
2. Message consumer instance(s) is running in a separate process, typically on multiple nodes in a cloud, such as AWS [events-service.js](js/events-service.js)
3. Consumer stores webhook events in the database potentially calling an API to get full record of the object that triggered the event
   - This application uses MySQL, the methods working with the database can be seen in [db-helper.js](js/db-helper.js)
4. Other services/objects fetch the events data from the database sorted by timestamp of the event [db-helper.js](js/db-helper.js)


### Note on the Data Base
This application uses MySQL database to store the events coming from Webhooks. There is a events table:
```
create table if not exists events (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  event_type      VARCHAR(255),
  property_name   VARCHAR(255),
  property_value  VARCHAR(255),
  object_id       bigint     default null,
  event_id        bigint     default null,
  occurred_at     bigint     default null,
  shown           tinyint(1) default 0,
  created_at      datetime   default CURRENT_TIMESTAMP
);`
```

Please note that event_id sent by HubSpot needs to be stored as int

This application uses MySQL database to store tokens info. There is a tokens table:
```
`create table if not exists tokens  (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  refresh_token  VARCHAR(255)   default null,
  access_token   VARCHAR(255)   default null,
  expires_in     bigint         default null,
  created_at     datetime       default CURRENT_TIMESTAMP,
  updated_at     datetime       default CURRENT_TIMESTAMP
);`
```

This application uses MySQL database to store webhooks initialization info. There is a urls table:
```
`create table if not exists urls  (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  url                    VARCHAR(255)   default null,
  webhooks_initialized   boolean        default 0
);`
```

### Setup App

Make sure you have [Docker Compose](https://docs.docker.com/compose/) and [Ngrok](https://ngrok.com/) installed.

### Configure

1. Copy .env.template to .env
2. Paste your HUBSPOT_CLIENT_ID, HUBSPOT_CLIENT_SECRET, HUBSPOT_APPLICATION_ID & HUBSPOT_DEVELOPER_API_KEY

### Running

The best way to run this project (with the least configuration), is using docker compose.  Change to the webroot and start it

```bash
docker-compose up --build
```

Copy the Redirect URL from the console and update your application to use it.
Give the change some time to propagate to the HubSpot OAuth servers.

Copy Ngrok url from console. Now you should now be able to navigate to that url and use the application.

### NOTE about Ngrok Too Many Connections error

If you are using Ngrok free plan and testing the application with large amount of import/deletions of Contacts you are likely to see Ngrok "Too Many Connections" error.
This is caused by a large amount of weebhooks events being sent to Ngrok tunnel. To avoid it you can deploy sample applications on your server w/o Ngrok or upgrade to Ngrok Enterprise version

### NOTE about webhooks

Application automatically configures webhooks after successful authorization:
 - creates if not exist `contact.creation`, `contact.deletion`, `contact.propertyChange` for `firstname` and `contact.propertyChange` for `lastname` subscriptions;
 - deactivates subscriptions with `eventType` different than `contact.creation`, `contact.deletion` or `contact.propertyChange`;
 - change subscription link to https://***.ngrok.io/webhooks
