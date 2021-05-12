import datetime
from flask import Blueprint, render_template, request, jsonify
from auth import auth_required
from services.db import session, Event
from helpers.hubspot import create_client
from hubspot.crm.contacts import (
    BatchReadInputSimplePublicObjectId,
    SimplePublicObjectId,
)

module = Blueprint("events", __name__)


@module.route("/")
@auth_required
def list():
    events = session.query(Event).order_by(Event.occurred_at.desc()).limit(50).all()
    session.commit()

    return render_template(
        "events/list.html",
        events=events,
        now=datetime.datetime.now(),
    )


@module.route("/updates")
def updates():
    after = datetime.datetime.fromisoformat(request.args.get("after"))
    updates_count = session.query(Event).filter(Event.created_at > after).count()
    session.commit()

    return jsonify(
        {
            "updatesCount": updates_count,
        }
    )
