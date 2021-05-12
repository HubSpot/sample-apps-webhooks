from flask import Blueprint, request
import json
import os
import datetime
from services.db import Event, session
from auth import hubspot_signature_required

module = Blueprint("webhooks", __name__)

@module.route("/handle", methods=["POST"])
@hubspot_signature_required
def handle():
    messsages = json.loads(request.data)
    producer = get_producer()
    for message in messages:
        event = Event()
        event.event_type = message["subscriptionType"]
        event.event_id = message["eventId"]
        event.object_id = message["objectId"]
        event.occurred_at = datetime.datetime.fromtimestamp(message["occurredAt"] // 1000)

        if "propertyName" in message:
            event.property_name = message["propertyName"]
            
        if "propertyValue" in message:
            event.property_value = message["propertyValue"]

        session.add(event)
        session.commit()

    return "", 204
