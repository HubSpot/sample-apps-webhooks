FROM python:3.8

RUN mkdir -p /app
ADD ./requirements.txt /app
WORKDIR /app
RUN pip install -r requirements.txt

ENV DOCKERIZE_VERSION v0.6.1
ADD https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz /tmp
RUN tar -C /usr/local/bin -xzvf /tmp/dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz

WORKDIR /app/src

CMD [ "python", "-m" , "flask", "run", "--host=0.0.0.0"]
