# HubSpot Webhooks sample app

This is a sample app for the HubSpot [client libraries](https://developers.hubspot.com/docs/api/overview). This sample app demonstrates how to work with Hubspot webhooks.

## Reference

- [Webhooks API](https://developers.hubspot.com/docs/api/webhooks)

## How to run locally

1. The first step is to [create a HubSpot developer account](https://developers.hubspot.com/docs/api/developer-tools-overview). This is where you will create and manage HubSpot apps.
2. Next [create an app](https://developers.hubspot.com/docs/api/creating-an-app). On the "App info" tab, You will be prompted to fill out some basic information about your app. This includes name, description, logo, etc.
   On the "Auth" tab, assign the scope `crm.objects.contacts`.
3. Copy the .env.template file into a file named .env in the folder of the language you want to use. For example:

```
cp node/.env.template node/.env
```

4. Paste your HubSpot API Key as the value for HUBSPOT_API_KEY in .env
5. Follow the language instructions on how to run.

## Supported languages

* [JavaScript (Node)](node/README.md)
* [Php](php/README.md)
* [Python](python/README.md)
* [Ruby](ruby/README.md)
